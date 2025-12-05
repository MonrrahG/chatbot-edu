<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #e7ecf5;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .junior {
        background: #ffffff;
        width: 380px;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.15);
    }

    h2 {
        text-align: center;
        margin-bottom: 15px;
        color: #2a4d69;
    }

    #MSGcamp {
        width: 100%;
        padding: 5px;
        border: 1px solid #aaa;
        border-radius: 8px;
        margin-bottom: 10px;
        font-size: 15px;
    }

    button {
        padding: 10px 12px;
        border: none;
        border-radius: 8px;
        background: #2a4d69;
        color: white;
        cursor: pointer;
        margin: 5px 3px;
        transition: 0.3s;
    }

    button:hover {
        background: #173248;
    }

    #chat {
        height: 280px;
        background: #f5f7fa;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        margin-top: 10px;
        margin-bottom: 10px;
        overflow-y: auto;
        font-size: 16px;
    }

    /* Estilo das mensagens */
    .mensagem-user {
        background: #d0e6ff;
        padding: 8px;
        border-radius: 8px;
        margin-bottom: 6px;
        text-align: right;
        color: #003366;
    }

    .mensagem-bot {
        background: #e8e8e8;
        padding: 8px;
        border-radius: 8px;
        margin-bottom: 6px;
        color: #333;
    }

    .controls {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .small-btn {
        padding: 6px 10px;
        font-size: 18px;
        width: 38px;
    }
    </style>
</head>
<body>
    <div class="junior">
        <h2>Chatbot da Enfermagem</h2>
        <input id="MSGcamp" placeholder="Digite a Mensagem Aqui">
        <button onclick="sendMSG()">Enviar</button>
        <div id="chat"></div>
        <button onclick = "limparChat()">Limpar chat</button>
        <button onclick = "aumentarFonte()">+</button>
        <button onclick = "diminuiFonte()">-</button>
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

        function limparChat() {
    document.getElementById("chat").innerHTML = "";
}

let tamanhoFonte = 16;

function aumentarFonte() {
    tamanhoFonte += 2;
    document.getElementById("chat").style.fontSize = tamanhoFonte + "px";
}

function diminuirFonte() {
    tamanhoFonte -= 2;
    if (tamanhoFonte < 10) tamanhoFonte = 10;
    document.getElementById("chat").style.fontSize = tamanhoFonte + "px";
}
    </script>
</body>
</html>
