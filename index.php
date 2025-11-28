<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Chamados</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
            transition: background-color 0.3s ease;
        }

        /* Tema Escuro */
        body.tema-escuro {
            background-color: #1a1a1a;
        }

        body.tema-escuro .main-content {
            background-color: #1a1a1a;
        }

        body.tema-escuro .card {
            background-color: #2c2c2c;
            color: #e0e0e0;
        }

        body.tema-escuro .card h3 {
            color: #e0e0e0;
        }

        body.tema-escuro .card .count {
            color: #3498db;
        }

        body.tema-escuro .form-container {
            background-color: #2c2c2c;
            color: #e0e0e0;
        }

        body.tema-escuro .form-title {
            color: #e0e0e0;
        }

        body.tema-escuro .form-group label {
            color: #e0e0e0;
        }

        body.tema-escuro .form-group select,
        body.tema-escuro .form-group textarea {
            background-color: #3c3c3c;
            color: #e0e0e0;
            border-color: #555;
        }

        body.tema-escuro .form-group select:focus,
        body.tema-escuro .form-group textarea:focus {
            border-color: #3498db;
            outline: none;
        }

        body.tema-escuro .header {
            border-bottom-color: #444;
        }

        body.tema-escuro .header h2 {
            color: #e0e0e0;
        }

        body.tema-escuro .user-info {
            color: #999;
        }

        /* Menu Lateral */
        .sidebar {
            width: 220px;
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            height: 100vh;
            position: fixed;
        }

        .logo {
            padding: 0 20px 20px;
            border-bottom: 1px solid #34495e;
            margin-bottom: 20px;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .menu {
            list-style: none;
        }

        .menu li {
            padding: 12px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .menu li:hover {
            background-color: #34495e;
        }

        .menu li.active {
            background-color: #3498db;
            border-left: 4px solid #2980b9;
        }

        /* Conteúdo Principal */
        .main-content {
            flex: 1;
            margin-left: 220px;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }

        .nav-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .tab {
            padding: 8px 16px;
            background-color: #ecf0f1;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .tab.active {
            background-color: #3498db;
            color: white;
        }

        .tab:hover:not(.active) {
            background-color: #d5dbdb;
        }

        /* Cards de Status */
        .status-cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            flex: 1;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .card .count {
            font-size: 2rem;
            font-weight: bold;
            color: #3498db;
        }

        /* Formulário de Chamado */
        .form-container {
            background-color: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .form-title {
            margin-bottom: 20px;
            color: #2c3e50;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
        }

        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }
    </style>
</head>
<body>
    <!-- Menu Lateral -->
    <div class="sidebar">
        <div class="logo">
            <h1>Sistema de Chamados</h1>
        </div>
        <ul class="menu">
            <li class="active" onclick="navegarPara('index.html')">Home</li>
            <li onclick="navegarPara('configuracoes.html')">Configurações</li>
        </ul>
    </div>

    <!-- Conteúdo Principal -->
    <div class="main-content">
        <div class="header">
            <h2>Home</h2>
            <div class="user-info">Usuário</div>
            <?php
                if(isset($_SESSION['id_ususario'])){
                    echo "Olá, ".$SESSION['nm_usuario'];
                }
                else{
                    echo "<script> alert('Você não está logado!') history.back(); </script>";
                }
            ?>
        </div>

        <div class="nav-tabs">
            <div class="tab active" onclick="navegarPara('index.html')">Home</div>
            <div class="tab" onclick="navegarPara('abertos.html')">Abertos</div>
        </div>

        <div class="status-cards">
            <div class="card">
                <h3>Criar um Chamado</h3>
                <div class="count">+</div>
            </div>
            <div class="card">
                <h3>Abertos</h3>
                <div class="count">0</div>
            </div>
            <div class="card">
                <h3>Pendentes</h3>
                <div class="count">0</div>
            </div>
        </div>

        <div class="form-container">
            <h2 class="form-title">Criar Novo Chamado</h2>
            <form id="form-chamado">
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select id="tipo" name="tipo" required>
                        <option value="">Selecione o tipo</option>
                        <option value="Problema Técnico">Problema Técnico</option>
                        <option value="Dúvida">Dúvida</option>
                        <option value="Solicitação">Solicitação</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="urgencia">Urgência</label>
                    <select id="urgencia" name="urgencia" required>
                        <option value="">Selecione a urgência</option>
                        <option value="Baixa">Baixa</option>
                        <option value="Média">Média</option>
                        <option value="Alta">Alta</option>
                        <option value="Urgente">Urgente</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" placeholder="Descreva o problema ou solicitação" required></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary" onclick="limparFormulario()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sistema de Tema
        function aplicarTema(tema) {
            const body = document.body;
            if (tema === 'escuro') {
                body.classList.add('tema-escuro');
            } else {
                body.classList.remove('tema-escuro');
            }
            localStorage.setItem('tema', tema);
        }

        function carregarTema() {
            const temaSalvo = localStorage.getItem('tema') || 'claro';
            aplicarTema(temaSalvo);
        }

        // Carregar tema ao iniciar
        carregarTema();

        // Carregar contadores ao iniciar
        document.addEventListener('DOMContentLoaded', function() {
            atualizarContadores();
        });

        // Função de navegação
        function navegarPara(pagina) {
            window.location.href = pagina;
        }

        // Função para limpar formulário
        function limparFormulario() {
            document.getElementById('form-chamado').reset();
        }

        // Função para validar formulário
        function validarFormulario() {
            const tipo = document.getElementById('tipo').value;
            const urgencia = document.getElementById('urgencia').value;
            const descricao = document.getElementById('descricao').value.trim();

            if (!tipo || tipo === '') {
                alert('Por favor, selecione o tipo do chamado.');
                return false;
            }

            if (!urgencia || urgencia === '') {
                alert('Por favor, selecione a urgência do chamado.');
                return false;
            }

            if (!descricao || descricao === '') {
                alert('Por favor, preencha a descrição do chamado.');
                return false;
            }

            if (descricao.length < 10) {
                alert('A descrição deve ter pelo menos 10 caracteres.');
                return false;
            }

            return true;
        }

        // Função para salvar chamado no banco de dados
        function salvarChamado(dados) {
            const formData = new FormData();
            formData.append('tipo', dados.tipo);
            formData.append('urgencia', dados.urgencia);
            formData.append('descricao', dados.descricao);

            return fetch('php/salvar_chamado.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Chamado criado com sucesso!');
                    limparFormulario();
                    atualizarContadores();
                } else {
                    alert('Erro ao criar chamado: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao salvar chamado. Tente novamente.');
            });
        }

        // Função para atualizar contadores de chamados
        function atualizarContadores() {
            fetch('php/contar_chamados.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const abertosElement = document.querySelector('.status-cards .card:nth-child(2) .count');
                        const pendentesElement = document.querySelector('.status-cards .card:nth-child(3) .count');
                        if (abertosElement) abertosElement.textContent = data.abertos;
                        if (pendentesElement) pendentesElement.textContent = data.pendentes;
                    }
                })
                .catch(error => console.error('Erro ao atualizar contadores:', error));
        }

        // Handler do formulário
        document.getElementById('form-chamado').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validar formulário
            if (!validarFormulario()) {
                return;
            }

            // Preparar dados do chamado
            const dadosChamado = {
                tipo: document.getElementById('tipo').value,
                urgencia: document.getElementById('urgencia').value,
                descricao: document.getElementById('descricao').value.trim(),
                data: new Date().toISOString(),
                status: 'Aberto'
            };

            // Salvar chamado (será substituído por chamada ao backend)
            salvarChamado(dadosChamado);
        });
    </script>
</body>
</html>