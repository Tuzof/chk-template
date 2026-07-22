<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Index by Metralha">
    <meta name="author" content="Metralha">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>



    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
    <link rel="icon" type="image/png" sizes="16x16" href="https://hackerhostel.com.jm/images/Hacker-hostel-react-developer.png">
    <title>[ CHK FULL 3.0 - CIELO ]</title>
	<style>
	body {
		background-image: linear-gradient(to right bottom, #000000, #080808, #0f0f0f, #151515, #191919, #1a1a1a, #1c1c1c, #1d1d1d, #1b1b1b, #191919, #181818, #161616);
	}

	@-webkit-keyframes AnimationName {
		0%{background-position:0% 2%}
		50%{background-position:100% 99%}
		100%{background-position:0% 2%}
	}
	@-moz-keyframes AnimationName {
		0%{background-position:0% 2%}
		50%{background-position:100% 99%}
		100%{background-position:0% 2%}
	}
	@-o-keyframes AnimationName {
		0%{background-position:0% 2%}
		50%{background-position:100% 99%}
		100%{background-position:0% 2%}
	}
	@keyframes AnimationName {
		0%{background-position:0% 2%}
		50%{background-position:100% 99%}
		100%{background-position:0% 2%}
	}
	.label {
        padding: 1px 3px 2px 3px;
        line-height: 13px;
        color: #fff;
        font-weight: 400;
        border-radius: 4px;
        font-size: 75%;
        display: inline;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
      }
      .label-green {
        background-color: #18BBA3;
        color:#fff;
      }
      .btn-success[disabled]{
        background-color: #18BBA3;
        border-color:transparent;
      }
      .label-red {
        background-color: #d9534f;
        color:#fff;
      }
      .label-white {
        background-color:#fff;
        color:#0a0a0a
      }
      .label-black {
        background-color:#0a0a0a;
        color:#fff
      }
      .label-light {
        background-color:#f5f5f5;
        color:#363636
      }
      .label-dark {
        background-color:#363636;
        color:#f5f5f5
      }
      .label-link {
        background-color:#3273dc;
        color:#fff
      }
      .label-info {
        background-color:#209cee;
        color:#fff
      }
      .label-success {
        background-color:#23d160;
        color:#fff
      }
      .label-warning {
        background-color:#ffdd57;
        color:rgba(0,0,0,.7)
      }
      .label-danger {
        background-color:#ff3860;
        color:#fff
      }
	  .time {
		  background:none;
		  color:white;
		  border: none;
		  outline:none;
		  margin:0 30px 0 30px;
	  }
	  .listreprovadas {
		  margin: 30px;
	  }
	  select, textarea, button {
         outline: none;
         box-shadow:none !important;
      }
	  </style>
	<body>
	<center>
	<div class='row' style="margin-top:90px;">
		
		<div class="col" style="margin:0 60px 30px 60px;">
			<button type="button" data-toggle="tooltip" data-placement="top" title="Esconder lista" class="btn" style="margin-left:10px;width:100%;position:relative;border-bottom:1px solid white;background:none;color:white;border-radius:0px;" onclick="esconder('lista')">
					<i class="fas fa-eye-slash"></i>
			</button>
			<textarea class='lista' id="lista" style="margin-left:10px;background-color: rgba(0, 0, 0, 0.5);color:white;outline:0;border:none;height: 250px;width:100%;resize:none; text-align: center; font-family: sans-serif;padding:16px;"></textarea>
		</div>
		<div class="form-group" style="max-width: 55rem;background-color: rgba(0, 0, 0, 0.5);color:white;outline:0;border:none;padding:16px;margin-right:90px;">
			<div style='margin:6px;color:white;'>
				<b>Delay do testador:</b> <input class='time' type="time" id="seconds" value="00:00" name="seconds" min="00:00" max="00:09" required>
			</div>
			<div style='margin-top:30px;'>
				<button type="button" class="btn btn-success" style="background-color: rgba(255, 38, 186, 0.5);border:none;width:100%;margin-bottom:3px;border-radius:0px;" id="start" onclick="javascript:start('casasbahia')">
					<i class="bx bx-loader bx-spin font-size-16 align-middle mr-2"></i> Iniciar
				</button>
				<br>
				<br>
				<button type="button" class="btn btn-danger" style="background-color: rgba(255, 38, 186, 0.5);border:none;width:100%;margin-bottom:3px;border-radius:0px;" id="stop" onclick="javascript:stop()">
					<i class="bx bx-block font-size-16 align-middle mr-2"></i> Parar
				</button>
			</div>
			<br>
			<br>
			<h9> CHECKER DE FULL </h9><br>
			<h9> GATE - CIELO KEY </h9>
			<br>
			<br>
			<h7> usem acima de 00:03 de (Delay) !  </h7>
		</div>
	</div>
	<div class="form-group" style="color:white;margin-left:-400px;">
		<strong>APROVADAS: <label class="badge badge-success" id="countLives">0</label> REPROVADAS: <label class="badge badge-danger" id="countDies">0</label> TESTADAS: <label class="badge badge-info" id="countChecked">0</label> CARREGADAS <label class="badge badge-dark" id="countTotal">0</label></strong>
	</div>
	</center>
		<div class="card" style="border:none;background-color:transparent;padding:0px 70px 0px;">
			<table class="table" style="margin-bottom:30px;background-color: rgba(0, 0, 0, 0.5);color:white;">
			  <thead class="thead-dark">
				<tr>
					<th scope="col">
						<span style="position:absolute;margin-top:0.2%;">APROVADAS</span>
						<span style="float:right;">
							<button class="btn" style="background:none;color:white;" onclick="copiarlist('listaprovadas')"><i class="fas fa-copy"></i></button>
							<button class="btn" style="background:none;color:white;" onclick="esconder('listaprovadas')"><i class="fas fa-eye-slash"></i></button>
						</span>
					</th>
				</tr>
			  </thead>
			  <tbody style="padding:6px;">
				<tr>
					<td class="listaprovadas"></td>
				</tr>
			  </tbody>
			</table>
			<table class="table" style="margin-bottom:30px;background-color: rgba(0, 0, 0, 0.5);color:white;">
			  <thead class="thead-dark">
				<tr>
					<th scope="col">
						<span style="position:absolute;margin-top:0.2%;">REPROVADAS</span>
						<span style="float:right;">
							<button class="btn" style="background:none;color:white;" onclick="copiarlist('listreprovadas')"><i class="fas fa-copy"></i></button>
							<button class="btn" style="background:none;color:white;" onclick="esconder('listreprovadas')"><i class="fas fa-eye-slash"></i></button>
						</span>
					</th>
				</tr>
			  </thead>
			  <tbody style="padding:6px;">
				<tr>
					<td class="listreprovadas"></td>
				</tr>
			  </tbody>
			</table>
		</div>
		<script>
			chkname = "";
			isSaldo = "nao";
			$(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			})
			$(document).ready(function(){
				$("select#testador").change(function(){
					var selected = $(this).children("option:selected").val();
					chkname = selected;
				});
				$("#seconds").click(function(){
					seconds = $("#seconds").val().replace("00:0", "");
				});
				$("select#isSaldo").change(function(){
					var selected = $(this).children("option:selected").val();
					isSaldo = selected;
				});
			});
		
			seconds = $("#seconds").val();
			const audioLive = new Audio('assets/audio/note.mp3');
			const totalCarregamento = async function(qtd, only=false){
				if(only)
					return $("#countTotal")[0].textContent = qtd
				
				const value = parseInt($("#countTotal")[0].textContent) + qtd; 
				$("#countTotal")[0].textContent = value
			}

			const moreOne = async function(elementId){
				const element = $(`#${elementId}`)[0];
				var value = parseInt(element.textContent);
				element.textContent = value+1;
			}

			const accountLive = async function(value){
				$(".listaprovadas").append(value + "<br>");
				moreOne("countLives");
				moreOne("countChecked");
			}

			const accountLivePlus = async function(value){
				audioLive.play();
				$(".listaprovadasplus").append(value + "<br>");
				moreOne("countLives");
				moreOne("countChecked");
			}

			const accountDie = async function(value){
				$(".listreprovadas").append(value + "<br>");
				moreOne("countDies");
				moreOne("countChecked");
			}
			
			const accountError = async function(value){
				moreOne("countError");
				moreOne("countChecked");
			}

			const clearList = async function(verify, value){
				if(verify && value == 10)
					$("#lista")[0].value = "";
			}

			function sleep(ms) {
				return new Promise(resolve => setTimeout(resolve, ms));
			}

			const esconder = async function(type){
				var value = $(`.${type}`)[0].style.display;
				$(`.${type}`)[0].style.display = value ? "" : "none";
			}

			const copiarlist = async function(type){
				var copyText = $(`.${type}`)[0]
				window.getSelection().selectAllChildren(copyText);
				document.execCommand("copy");
			}

			const resetChecker = function(){
				$("#countChecked")[0].textContent[0] = "0";
				$("#countTotal")[0].textContent[0] = "0";
				$("#countLives")[0].textContent[0] = "0";
				$("#countDies")[0].textContent[0] = "0";
			}

			const removelinha = function() {
				var lines = $("#lista").val().split('\n');
				lines.splice(0, 1);
				$("#lista").val(lines.join("\n"));
			}

			const checkar = async function(value){
				$.ajax({
					url: "api.php?chk=" + chkname + "&lista=" + value + "&saldo=" + isSaldo,
					method: "GET",
					async: true,
					contentType: 'application/json',
					success: function(response){
						var testadas = parseInt($("#countChecked")[0].textContent)
						var total = parseInt($("#countTotal")[0].textContent)
						if((total - testadas) <= 2)
							$("#start")[0].disabled = false;

						var value = response;
						if(response.match("#TOPAPROVADA")){
							accountLivePlus(value);
						}else if(response.match("#Live")){
							accountLive(value);
						}else if(response.match("#Reprovada")){
							accountDie(value)
						}else{
							accountError(value)
						}
						removelinha();
					}
				})
			}

			const stop = async function(){
				$("#start")[0].disabled = false;
				_continue = false;
			}
			var _continue;

			const start = async function(name){
				const time = seconds * 1000;
				console.log(seconds);
				_continue = true;
				var values = $("#lista").val()

				var filter = duplicateRemove(values)

				if(!filter.length)
					return stop();
				
				$("#lista").text(filter.join("\n"));                
				if(filter.length > 1000) return alert("Coloque no maximo 1000 ccs. Carregado: ".concat(filter.length))
				resetChecker()
				totalCarregamento(filter.length);
				$("#start")[0].disabled = true;

				for(var i=0; i<filter.length ;i++){
					if(!_continue){
						break;
					}
					var value = filter[i];
					checkar(value);
					await sleep(time);
				}
			}

			const duplicateRemove = function(text){
				var linhas = text.split('\n');

				var newArr = linhas.filter(function(element, i) {
					return (linhas.indexOf(element) === i && element.length) ;
				})

				return newArr.length ? newArr : false;
			}
		</script>
	</body>
</html>