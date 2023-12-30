<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Busca CEP</title>
</head>

<body>
    <div class="container">
        <h1 class="mt-3">Busca CEP</h1>
        <hr>
        <div class="alert alert-danger d-none" id="alert-erro">CEP não encontrado.</div>
        <div class="spinner-border d-none" role="status" id="spin">
            <span class="visually-hidden">Loading...</span>
        </div>
        <form method="post">
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" name="cep" id="cep" class="form-control">
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" name="endereco" id="endereco" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" name="numero" id="numero" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label for="complemento" class="form-label">Complemento</label>
                        <input type="text" name="complemento" id="complemento" class="form-control">
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" name="bairro" id="bairro" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" name="cidade" id="cidade" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="estado" class="form-label">UF</label>
                        <input type="text" name="estado" id="estado" class="form-control">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script src="jquery.mask.min.js"></script>
    <script>
        $('#cep').mask('00.000-000');

        document.querySelector('#cep').addEventListener('keyup', function(e) {
            let cep = e.target.value;
            let cepLimpo = cep.replace('.', '').replace('-', '');

            if (cepLimpo.length >= 8) {
                document.querySelector('#spin').classList.remove('d-none');

                const url = `https://viacep.com.br/ws/${cepLimpo}/json/`;

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            document.querySelector('#spin').classList.add('d-none');
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {

                        if (data.erro) {
                            document.querySelector('#alert-erro').classList.remove('d-none');
                            document.querySelector('#spin').classList.add('d-none');
                            return;
                        }

                        document.querySelector('#endereco').value = data.logradouro;
                        document.querySelector('#complemento').value = data.complemento;
                        document.querySelector('#bairro').value = data.bairro;
                        document.querySelector('#cidade').value = data.localidade;
                        document.querySelector('#estado').value = data.uf;
                        document.querySelector('#alert-erro').classList.add('d-none');
                        document.querySelector('#spin').classList.add('d-none');
                    })
                    .catch(error => {
                        console.error('Houve um problema na requisição:', error);
                        document.querySelector('#spin').classList.add('d-none');
                    });
            } else {
                document.querySelector('#endereco').value = '';
                document.querySelector('#complemento').value = '';
                document.querySelector('#bairro').value = '';
                document.querySelector('#cidade').value = '';
                document.querySelector('#estado').value = '';
                document.querySelector('#alert-erro').classList.add('d-none');
                document.querySelector('#spin').classList.add('d-none');
            }
        });
    </script>
</body>

</html>