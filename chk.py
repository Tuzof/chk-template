#!/usr/bin/env python3
"""
Template base para chk - ADAPTE PARA SEU ALVO
Uso: python chk.py -t targets.txt -th 50
"""
import argparse
import sys
import threading
import queue
import requests
from colorama import Fore, Style, init

init(autoreset=True)

def worker(q, results, lock):
    session = requests.Session()
    session.headers.update({'User-Agent': 'Mozilla/5.0'})
    
    while True:
        try:
            target = q.get(timeout=1)
        except queue.Empty:
            break
            
        try:
            # TODO: IMPLEMENTE SUA LÓGICA DE CHECK AQUI
            # Exemplo: resp = session.get(target, timeout=10)
            # if "sucesso" in resp.text: ...
            
            with lock:
                results.append(f"{target} | CHECKED")
        except Exception as e:
            with lock:
                results.append(f"{target} | ERROR: {e}")
        finally:
            q.task_done()

def main():
    parser = argparse.ArgumentParser()
    parser.add_argument('-t', '--targets', required=True, help='Arquivo com targets (um por linha)')
    parser.add_argument('-th', '--threads', type=int, default=50, help='Threads paralelas')
    args = parser.parse_args()

    with open(args.targets) as f:
        targets = [line.strip() for line in f if line.strip()]

    q = queue.Queue()
    for t in targets:
        q.put(t)

    results = []
    lock = threading.Lock()
    threads = []

    print(f"{Fore.CYAN}[*] Iniciando chk com {args.threads} threads | {len(targets)} targets{Style.RESET_ALL}")

    for _ in range(args.threads):
        t = threading.Thread(target=worker, args=(q, results, lock))
        t.start()
        threads.append(t)

    q.join()

    for t in threads:
        t.join()

    # Salva resultados
    with open('results.txt', 'w') as f:
        f.write('\n'.join(results))

    print(f"{Fore.GREEN}[+] Concluído. Resultados em results.txt{Style.RESET_ALL}")

if __name__ == '__main__':
    main()
