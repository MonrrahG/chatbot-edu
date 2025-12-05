<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="junior">
        <h2>Chatbot da Enfermagem</h2>
        <input id="MSGcamp" placeholder="Digite a Mensagem Aqui">
        <button onclick="sendMSG()">Enviar</button>
        <div id="chat"></div>
    </div>

    <script>
        function showMSG(texto, classe){
            const chat = document.getElementById("chat");
            const p = document.createElement("p");
            p.className = classe;
            p.textContent = texto;
            chat.appendChild(p);
            chat.scrollTop = chat.scrollHeight;
        }
        function sendMSG(){
            const msg = document.getElementById("MSGcamp").value;
            
            if (msg.trim() === "") return;

            showMSG("Você: " + msg, "mensagem-user");
            document.getElementById("MSGcamp").value = "";

            fetch("gemini.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "mensagem=" + encodeURIComponent(msg)
            })

            .then(res => res.json())
            .then(data => {
                showMSG("Chatbot: " + data.resposta, "mensagem-bot");
            })
            .catch(() =>{
                showMSG("Chatbot: Erro ao se conectar ao servidor.", "mensagem-bot");
            })
        }
    </script>
</body>
</html>