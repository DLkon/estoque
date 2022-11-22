<?php 
                include 'conectaBanco.php';
                $select = "SELECT * FROM usuario";
                $result = $conn->query($select);

                while ($row = $result->fetch_assoc()) {
                    $nome = $row['nome'];
                    $email = $row['email'];
                    $telefone = $row['telefone'];
                    $endereco = $row['endereco'];
                    $cpf = $row['cpf'];
                    $senha = $row['senha'];


                    echo "
                    <tbody>
                        <tr>
                            <td>$nome</td>
                            <td>$email</td>
                            <td>$telefone</td>
                            <td>$endereco</td>
                            <td>$cpf</td>
                            <td>$senha</td>
                        </tr>
                    </tbody>";
                }
            ?>