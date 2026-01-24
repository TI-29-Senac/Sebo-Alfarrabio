<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Categoria</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        
        .header-gradient {
            background: linear-gradient(135deg, #A78B71 0%, #8B7355 100%);
            padding: 40px 20px;
        }
        
        .header-content {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .header-title-container {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .header-icon {
            font-size: 42px;
            color: #FFD700;
        }
        
        .header-title {
            color: white;
            font-size: 36px;
            margin: 0;
            font-weight: 600;
        }
        
        .header-subtitle {
            color: rgba(255,255,255,0.9);
            margin: 0;
            font-size: 16px;
        }
        
        .form-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .form-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .form-label {
            color: #8B7355;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-input,
        .form-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            font-family: inherit;
            transition: border-color 0.3s;
        }
        
        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #A78B71;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .button-group {
            margin-top: 40px;
            text-align: right;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-cancel {
            background: #f0f0f0;
            color: #666;
            margin-right: 10px;
        }
        
        .btn-cancel:hover {
            background: #e0e0e0;
        }
        
        .btn-save {
            background: #5CB85C;
            color: white;
        }
        
        .btn-save:hover {
            background: #4CAF50;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(92, 184, 92, 0.3);
        }
        
        @media (max-width: 768px) {
            .header-title {
                font-size: 28px;
            }
            
            .header-icon {
                font-size: 32px;
            }
            
            .form-card {
                padding: 25px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .button-group {
                text-align: center;
            }
            
            .btn {
                width: 100%;
                margin: 5px 0 !important;
            }
        }
    </style>
</head>
<body>

<div class="header-gradient">
    <div class="header-content">
        <div class="header-title-container">
            <i class="fa fa-plus-circle header-icon"></i>
            <h1 class="header-title">Nova Categoria</h1>
        </div>
        <p class="header-subtitle">Adicione uma nova categoria ao sistema</p>
    </div>
</div>

<div class="form-container">
    <form action="/backend/categoria/salvar" method="POST" enctype="multipart/form-data" class="form-card">

        <div class="form-row">
            <div>
                <label class="form-label">Nome da Categoria*</label>
                <input class="form-input" 
                       id="nome_categoria" 
                       name="nome_categoria" 
                       type="text" 
                       placeholder="Ex: Literatura, Filmes, Revistas..."
                       required>
            </div>

            <div>
                <label class="form-label">Tipo*</label>
                <select class="form-select" 
                        id="tipo_categoria" 
                        name="tipo_categoria" 
                        required>
                    <option value="" disabled selected>Selecione o tipo</option>
                    <option value="importado">Importado</option>
                    <option value="novo">Livro</option>
                    <option value="usado">CD</option>
                    <option value="raro">DVD</option>
                    <option value="antigo">Revista</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Imagem (opcional)</label>
            <input class="form-input" 
                   id="imagem" 
                   name="imagem" 
                   type="file" 
                   accept="image/*">
        </div>

        <div class="button-group">
            <a href="/categoria/listar" class="btn btn-cancel">
                <i class="fa fa-arrow-left"></i> Cancelar
            </a>

            <button type="submit" class="btn btn-save">
                <i class="fa fa-check"></i> Salvar Categoria
            </button>
        </div>
    </form>
</div>

</body>
</html>