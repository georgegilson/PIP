<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="assets/js/gmaps.js"></script>
<script src="assets/js/wizard.js"></script>
<script src="assets/js/bootstrap-multiselect.js"></script>
<script src="assets/js/bootstrap-maxlength.js"></script>

<form id="form" class="form-horizontal">
    <div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
        <?php
        $item = $this->getItem();
        if ($item) {
            foreach ($item as $imovel) {
                $referencia = $imovel->Referencia();
                $idImovel = $imovel->getId();
                $tipoImovel = $imovel->getTipo();
                $endereco = $imovel->getEndereco()->enderecoMapa();
                ?>
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Imóvel #<?php echo $referencia ?></h4>
                            </div>
                            <div class="modal-body">
                                <?php
                                echo "Finalidade: " . $imovel->getFinalidade() . "<br />";
                                echo "Tipo: " . $imovel->getTipo() . "<br />";
                                echo "Descrição: " . $imovel->getDescricao() . "<br />";
                                echo "Quartos: " . $imovel->getQuarto() . "<br />";
                                echo "Garagen(s): " . $imovel->getQuarto() . "<br />";
                                echo "Banheiro(s): " . $imovel->getBanheiro() . "<br />";
                                echo "Área: " . $imovel->getArea() . " m<sup>2</sup><br />";
                                echo "Suite(s): " . (($imovel->getSuite() != "nenhuma") ? '<span class="text-primary">' . $imovel->getSuite() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                echo "Academia: " . (($imovel->getAcademia() == "SIM") ? '<span class="text-primary">' . $imovel->getAcademia() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                echo "Área Serviço: " . (($imovel->getAreaServico() == "SIM") ? '<span class="text-primary">' . $imovel->getAreaServico() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                echo "Dependencia de Empregada: " . (($imovel->getDependenciaEmpregada() == "SIM") ? '<span class="text-primary">' . $imovel->getDependenciaEmpregada() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                echo "Elevador: " . (($imovel->getElevador() == "SIM") ? '<span class="text-primary">' . $imovel->getElevador() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                echo "Piscina: " . (($imovel->getPiscina() == "SIM") ? '<span class="text-primary">' . $imovel->getPiscina() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                echo "Quadra: " . (($imovel->getQuadra() == "SIM") ? '<span class="text-primary">' . $imovel->getQuadra() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                if ($tipoImovel == "apartamento") {
                                    echo "Andar: " . $imovel->getAndar() . "<br />";
                                    echo "Está na cobertura: " . (($imovel->getCobertura() == "SIM") ? '<span class="text-primary">' . $imovel->getCobertura() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                    echo "Possui sacada: " . (($imovel->getSacada() == "SIM") ? '<span class="text-primary">' . $imovel->getSacada() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                    echo "Valor do Condominio: " . $imovel->getCondominio() . "<br />";
                                }
                                ?>

                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <?php
            }
        }
        ?>
        <div class="row">
            <div class="alert alert-warning">Aguarde Processando...</div>
            <div class="well wizard-example">
                <div id="MyWizard" class="wizard">
                    <ul class="steps">
                        <li data-target="#step1" class="active"><span class="badge badge-info">1</span>Início<span class="chevron"></span></li>
                        <li data-target="#step2"><span class="badge">2</span>Seu Anúncio<span class="chevron"></span></li>
                        <li data-target="#step3"><span class="badge">3</span>Fotos<span class="chevron"></span></li>
                        <li data-target="#step4"><span class="badge">4</span>Confirmação<span class="chevron"></span></li>
                        <li data-target="#step5"><span class="badge">5</span>Publicado!<span class="chevron"></span></li>
                    </ul>
                    <div class="actions">
                        <button data-toggle="modal" data-target="#myModal" class="btn btn-success btn-sm"> <span class="glyphicon glyphicon-info-sign"> </span> Imóvel #<?php echo $referencia ?></button>
                        <button type="button" class="btn btn-warning btn-xs btn-prev"> <span class="glyphicon glyphicon-chevron-left"></span> Anterior </button>
                        <button type="button" class="btn btn-primary btn-xs btn-next" data-last="Fim"> Próximo <span class="glyphicon glyphicon-chevron-right"></span></button>
                    </div>
                </div>

                <div class="step-content">
                    <div class="step-pane active" id="step1">
                        <div class="row">
                            <div class="col-lg-12">
                                <p> Aqui vai ficar algum texto de introdução.</p>
                                <p> Será que vamos disponibilizar para a empresa um código como se fosse um voucher, que será validado.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="txtCodigo">Código de Publicação</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="txtCodigo" name="txtCodigo" placeholder="Informe o Código de Publicação">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-pane" id="step2">
                        <input type="hidden" id="hdnId" name="hdnId" value=""/>
                        <input type="hidden" id="hdnIdImovel" name="hdnIdImovel" value="<?php echo $idImovel; ?>" />
                        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio" />
                        <input type="hidden" id="hdnAcao" name="hdnAcao" value="Cadastrar" />
                        <div class="row">
                            <div class="col-lg-6">
                                <div id="forms" class="panel panel-default">
                                    <div class="panel-heading">Informações Básicas </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="txtTitulo">Título</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="txtTitulo" name="txtTitulo" placeholder="Informe o Título">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="txtDescricao"> Descrição </label>
                                        <div class="col-lg-8">
                                            <textarea maxlength="100" id="txtDescricao" name="txtDescricao" class="form-control" placeholder="Informe uma Descrição do Imóvel"> </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="txtValor">Valor</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="txtValor" name="txtValor" placeholder="Informe o Valor do Imóvel">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-6 control-label" for="rdbMapa"> Permitir a exibição do mapa?</label>
                                        <div class="col-lg-5">
                                            <label class="radio-inline">
                                                <input type="radio" name="rdbMapa" value="SIM" checked="checked"> Sim
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="rdbMapa" value="NÃO"> Não
                                            </label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-6 control-label" for="sltCamposVisiveis">Exibir as Informações Cadastradas</label>
                                        <div class="col-lg-5">
                                            <select class="form-control" id="sltCamposVisiveis" name="sltCamposVisiveis[]" multiple=multiple>
                                                <optgroup label="Informações Básicas">...</optgroup>
                                                <option value="quarto">Quarto</option>
                                                <option value="garagem">Garagem</option>
                                                <option value="banheiro">Banheiro</option>
                                                <optgroup label="Informações Adicionais">...</optgroup>                                                
                                                <option value="academia">Academia</option>
                                                <option value="areaservico">Área de Serviço</option>
                                                <option value="dependenciaempregada">Dependência de Empregada</option>
                                                <option value="elevador">Elevador</option>
                                                <option value="piscina">Piscina</option>
                                                <option value="quadra">Quadra</option>
                                                <option value="area">Área M<sup>2</sup></option>
                                                <option value="suite">Suíte</option>
                                                <option value="descricao">Descrição</option>
                                                <?php if ($tipoImovel == "apartamento") { ?>
                                                    <option value="andar">Andar</option>
                                                    <option value="cobertura">Cobertura</option>
                                                    <option value="sacada">Sacada</option>
                                                    <option value="condominio">Condominio</option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="forms" class="panel panel-default">
                                    <div class="panel-heading">Mapa do Endereço Cadastrado</div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="popin">
                                                <div id="map"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="step-pane" id="step3">
                    </div>
                    <div class="step-pane" id="step4">
                        <div class="row">
                            <h4>Confirme os dados informados:</h4>
                            <table class="table table-bordered table-condensed table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <th>Imóvel</th>
                                        <th>Voucher</th>
                                        <th>Título</th>
                                        <th>Descrição</th>
                                        <th>Valor</th>
                                        <th>Mapa</th>
                                        <th>Informações Exibidas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="colReferencia"><?php echo $referencia; ?></td>
                                        <td id="colVoucher"></td>
                                        <td id="colTitulo"></td>
                                        <td id="colDescricao"></td>
                                        <td id="colValor"></td>
                                        <td id="colMapa"></td>
                                        <td id="colCampos"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <textarea class="form-control" rows="5">Estas condições gerais regulam o acesso, visita, navegação, visualização e utilização de serviços, ferramentas e aplicativos, publicação e hospedagem dentro do website www.badabum.com.br, que é de propriedade da empresa BADABUM SOLUÇÕES DIGITAIS LTDA., inscrita no CNPJ sob o nº 17.330.213/0001-84, doravante designada BADABUM.

O website www.badabum.com.br será utilizado por pessoa física ou jurídica, que tenha capacidade jurídica para celebrar e cumprir o presente termo de uso, que doravante será designado como USUÁRIO.
CONSIDERANDO

Que a BADABUM é uma empresa que atua no ramo de informática com o fornecimento de ferramentas e aplicativos online, para criação, personalização e hospedagem de websites (Web Hosting - armazenamento eletrônico de páginas na Internet, para consulta por terceiros);

Que o USUÁRIO deseja criar e hospedar um website, seja em nome próprio, dele USUÁRIO, ou de terceiros em nome próprio (prática essa conhecida no mercado como “revenda de serviços de hospedagem de websites), utilizando as ferramentas, aplicativos e serviços fornecidos pela BADABUM;

Que para criar, personalizar e hospedar um website, utilizando as ferramentas, aplicativos e serviços da BADABUM, deverá o USUÁRIO estar previamente cadastrado no website www.badabum.com.br.

Por este instrumento e na melhor forma de direito as partes acima mencionadas, passam a estabelecer o seguinte.

I – DO CADASTRAMENTO DO USUÁRIO

Para testar, criar, personalizar e hospedar um website, utilizando as ferramentas, aplicativos e serviços da BADABUM, o USUÁRIO deverá se cadastrar previamente no website www.badabum.com.br, o qual deverá preencher os seguintes requisitos:

a) se pessoa física, ser maior de 18 anos;
b) se pessoa jurídica, ser preenchida por quem tenha poderes para representá-la e obrigá-la ao cumprimento do presente contrato;
c) possuir capacidade jurídica para celebrar e cumprir este contrato, não havendo nenhum impedimento para tanto;
d) ter condições econômicas de arcar com os pagamentos, custos e despesas decorrentes deste contrato.
OS PAIS OU OS REPRESENTANTES LEGAIS DE MENOR DE IDADE RESPONDERÃO PELOS ATOS POR ELE PRATICADOS SEGUNDO ESTE CONTRATO, DENTRE OS QUAIS EVENTUAIS DANOS CAUSADOS A TERCEIROS, PRÁTICAS DE ATOS VEDADOS PELA LEGISLAÇÃO E PELAS DISPOSIÇÕES DESTE CONTRATO.

O USUÁRIO declara e reconhece que as informações fornecidas são verdadeiras, corretas, atuais e completas, responsabilizando-se civil e criminalmente por estas informações.

O USUÁRIO autoriza expressamente a BADABUM manter em seu cadastro as informações fornecidas.

A BADABUM poderá utilizar todos os meios válidos e possíveis para identificar o USUÁRIO, bem como solicitar dados adicionais e documentos para verificação e confirmação dos dados de cadastramento informados.

Caso os dados informados pelo USUÁRIO no momento do cadastramento estejam errados e/ou incompletos, impossibilitando a comprovação e identificação do USUÁRIO, ou ainda, caso o USUÁRIO não envie ou demonstre os documentos requeridos pela BADABUM. A BADABUM poderá suspender temporariamente ou cancelar definitivamente o cadastro do USUÁRIO, inclusive com o cancelamento do website criado e hospedado nos servidores da BADABUM, sem a necessidade de prévio aviso, e com a possibilidade do USUÁRIO responder pelas perdas e danos eventualmente causados.

Havendo a aplicação de qualquer das sanções acima referidas, automaticamente serão canceladas os serviços contratados pelo USUÁRIO no website www.badabum.com.br, não assistindo ao USUÁRIO, por essa razão, qualquer sorte de indenização ou ressarcimento.

O USUÁRIO acessará sua conta através de login (email) e senha e compromete-se a não informar a TERCEIROS esses dados, responsabilizando-se integralmente pelo uso que deles seja feito. O USUÁRIO é responsável pela proteção da confidencialidade de sua senha pessoal.

O USUÁRIO compromete-se a notificar a BADABUM imediatamente, e através de meio seguro, a respeito de qualquer uso não autorizado de sua conta, bem como o acesso não autorizado por TERCEIROS à mesma.

O USUÁRIO será o único responsável pelas operações efetuadas em sua conta, uma vez que o login (email) e senha são de conhecimento exclusivo do USUÁRIO.

O USUÁRIO autoriza o recebimento de e-mail e correspondência enviados pela BADABUM, contendo informações sobre os serviços da BADABUM, ou ainda, com ofertas oferecidas por parceiros estratégicos da BADABUM, com o intuito de oferecer vantagens comerciais e/ou técnicas para o USUÁRIO.

É extremamente vedada a cessão, venda, aluguel ou outra forma de transferência da conta, ou ainda a criação de novos cadastros por pessoas cujos cadastros originais tenham sido cancelados por infrações às políticas do presente Termo de Uso.

II - DO OBJETO DO CONTRATO

A BADABUM prestará ao USUÁRIO os serviços que podem incluir, a formação, concepção, armazenamento, gestão, compartilhamento e vinculação de arquivos de mídia e/ou de documentos (incluindo, textos, comentários de usuários, mensagens, informações, dados, gráficos, fotografias, imagens, ilustrações, animações, áudio e vídeo, também conhecidos coletivamente como "Conteúdo"), próprios ou de terceiros, bem como a publicação e hospedagem de website.

O serviço funcionará com a utilização de templates de websites pré-definidos e de propriedade da BADABUM, e com o fornecimento de imagens, animações, vídeos, áudios, fontes e outros conteúdos pertencentes à BADABUM e/ou fornecidos por terceiros através da BADABUM, que poderão ser ajustados e personalizados de forma limitada, de acordo com a necessidade de cada USUÁRIO, observando o disposto neste contrato.

Os templates, imagens, animações, vídeos, áudios, fontes e outros conteúdos disponibilizados ao USUÁRIO dentro do website www.badabum.com.br, serão de propriedade, única e exclusiva, da BADABUM, sendo concedida uma permissão de uso durante a vigência e conforme o disposto neste contrato.

III – DO TESTE GRATUITO

O USUÁRIO poderá realizar, uma única vez, um teste gratuito onde o seu website será criado dentro da plataforma da BADABUM, e será publicado e hospedado dentro de um subdomínio do website www.badabum.com.br (exemplo: www.badadum.com.br/seusite), ou seja o usuário não terá um domínio próprio durante esse período.

A duração total do teste gratuito será de 15 (quinze) dias corridos, improrrogáveis, sendo que tal prazo terá início na data de realização do cadastro pelo USUÁRIO.

Após o término do período de teste gratuito, o USUÁRIO poderá optar pela contratação dos serviços da BADABUM, podendo escolher entre o plano semestral, anual ou 2 anos, conforme abaixo descrito.

Caso o USUÁRIO NÃO opte pela contratação de um dos planos de serviço, o seu website gratuito (teste) será imediatamente “retirado do ar”. Todas as informações para a configuração do website permanecerão arquivadas por 3 meses nos servidores da BABDAUM, para futura republicação do website do USUÁRIO, desde que tenha optado por um dos planos de serviço.

III - DO PREÇO, PRAZO, RENOVAÇÃO E REAJUSTES DO PRESENTE CONTRATO.

O USUÁRIO pagará à BADABUM pela prestação dos serviços objeto deste contrato, para cada um dos planos disponíveis (semestral, anual ou 2 anos), o valor especificado nos mencionados quadros para o plano escolhido, que está divulgado dentro do website www.badabum.com.br.

O presente contrato é celebrado pelo prazo contratado pelo USUÁRIO (semestral, anual ou 2 anos) e somente será renovado pela vontade EXPRESSA do USUÁRIO, o qual sempre poderá optar pela modalidade de prazo a ser escolhida, ou seja, a renovação do plano não se dará de forma automática.

O início da prestação dos serviços e, portanto, o início da fluência do prazo contratual ocorrerá no primeiro dia útil seguinte à comprovação do pagamento da primeira mensalidade, de acordo com a escolha e solicitação do serviço pelo USUÁRIO, que será realizada diretamente no website www.badabum.com.br.

Ao terminar o teste grátis de 15 dias, a utilização das ferramentas e aplicativos para criação do website, somente serão liberados após a comprovação de pagamento da primeira mensalidade cair no sistema da BADABUM.

Caso seja introduzida alguma alteração nas cláusulas e condições do presente contrato padrão, as cláusulas e condições alteradas passarão a reger o contrato ora celebrado de pleno direito a partir da primeira renovação automática posterior ao registro do novo texto padrão.

IV - DA FORMA DE PAGAMENTO

Os pagamentos devidos pelo USUÁRIO, em razão do presente contrato, serão realizados por meio do sistema de cobrança e gestão de pagamentos denominado PAGSEGURO. Qualquer outra forma de pagamento que não seja através do PAGSEGURO, não servirá como prova de quitação e ensejará a rescisão do contrato.

O sistema de cobrança PAGSEGURO trata-se de um serviço de gestão de pagamentos da UNIVERSO ONLINE S/A, com sede na cidade de São Paulo, Estado de São Paulo, na Avenida Brigadeiro Faria Lima, nº 1384, 6º andar, CEP 01452-002, inscrita no CNPJ/MF sob o nº 01.109.184/0001-95.

Para realizar o pagamento, o USUÁRIO no momento em que optar pelo plano da BADABUM, será redirecionado automaticamente para o website da PAGSEGURO (pagseguro.uol.com.br), onde deverá informar seus dados para realizar o pagamento, podendo inclusive ser obrigado à realizar um cadastro prévio no PAGSEGURO.

A BADABUM somente será informada sobre a confirmação do pagamento realizado pelo USUÁRIO, sendo que qualquer outra informação financeira e/ou bancária informadas pelo USUÁRIO ao PAGSEGURO, jamais será fornecida para a BADABUM.

Para se cadastrar e efetuar o pagamento através do PAGSEGURO, o USUÁRIO deverá respeitar os Contratos e o Termo de Uso daquela prestadora de serviço que está no website pagseguro.uol.com.br.

A BADABUM não se responsabiliza pelos serviços prestados pela PAGSEGURO, sendo que esta última será a única que se responsabilizará pelos atos por ela praticados.

5 - OBRIGAÇÕES DO USUÁRIO

São obrigações do USUÁRIO:

- Informar à BADABUM qualquer alteração dos dados de cadastros, incluindo troca de “e-mail”, sob pena de em não o fazendo considerarem-se válidos todos os avisos e notificações enviados para os endereços inicialmente informados e constantes do presente contrato.

- Responder pela veracidade das informações prestadas por ocasião da presente contratação, inclusive no que diz respeito à titularidade do seu website a ser hospedado e de seu domínio, bem como responder pela veracidade e exatidão das informações cadastrais prestadas, sob pena de, em caso de dúvida ou contestação dessas informações, IMEDIATA SUSPENSÃO DA PRESTAÇÃO DOS SERVIÇOS ORA CONTRATADOS INDEPENDENTEMENTE DE AVISO OU NOTIFICAÇÃO até a supressão das falhas de informação que permitam aferir documentalmente os pontos duvidosos ou questionados.

- Para a hipótese de o USUÁRIO descumprir a obrigação de manter atualizados seus dados cadastrais junto ao órgão de registro de domínio, fica a BADABUM, caso solicitada por terceiros, autorizada a fornecer o nome e endereço do USUÁRIO e do responsável pelo(s) website(s) hospedado(s).

- Não armazenar e nem veicular por meio do website, objeto deste contrato, qualquer material, som, imagem, programa que tenha material pornográfico, com pedofilia, ou que demonstre preconceito de raça, origem, credo, cor, condição social ou que afrontem a moral e os bons costumes, e/ou que seja caracterizado como “pirata” e/ou que afronte por qualquer outra maneira a legislação em vigor, não se limitando à estes exemplos, o USUÁRIO será cientificado das violações de contrato e, caso, no prazo máximo de 72 (setenta e duas) horas contado da sua cientificação não obtenha ordem judicial que autorize a continuidade da veiculação do “site” impugnado o mesmo será retirado do ar independentemente de novo aviso ou notificação.

- Abster-se de qualquer prática que possa ocasionar prejuízo ao regular funcionamento do servidor no tocante às suas especificações técnicas, dentro dos critérios técnicos aferíveis pela BADABUM, a qual fica desde já autorizada a adotar, mesmo preventivamente, qualquer medida que se faça necessária ou conveniente a impedir que se consume qualquer prejuízo ao regular funcionamento do servidor compartilhado, INCLUSIVE RETIRANDO DO AR OS SITES E/OU “BLOG” DO USUÁRIO.

- Fica vedado ao USUÁRIO instalar ou tentar instalar qualquer tipo de programa no servidor ou na plataforma da BADABUM, tais como, de forma exemplificativa.

a) Utilizar programas que por qualquer razão prejudiquem ou possam vir a prejudicar o funcionamento do servidor, SOB PENA DE IMEDIATA SUSPENSÃO DA PRESTAÇÃO DOS SERVIÇOS ORA CONTRATADOS INDEPENDENTEMENTE DE AVISO OU NOTIFICAÇÃO. 
b) Utilizar a hospedagem como espaço para armazenamento ou back-up de arquivos que não sejam elementos do “website” hospedado. 
c) Utilizar a hospedagem como “espelho” de outro “website” ou como servidor de “downloads”. 
d) Utilizar o “website” hospedado na BADABUM para instalar links com redirecionamento para outros websites que contenham software para navegação anônima; software para distribuição de conteúdo ilegal ou com copyright; hospedagem e distribuição de arquivos maliciosos: arquivos infectados com vírus ou malware, páginas de phishing, dentre outros; software para obtenção de credenciais por exaustão; software de scan para descoberta de informações, dentre outros, SOB PENA DE IMEDIATA SUSPENSÃO DA PRESTAÇÃO DOS SERVIÇOS ORA CONTRATADOS INDEPENDENTEMENTE DE AVISO OU NOTIFICAÇÃO.

- Sujeitar ou permitir que os sites sejam sujeitos a um volume excessivo de tráfego de dados que possa, de qualquer maneira vir a prejudicar o funcionamento do servidor, SOB PENA DE IMEDIATA SUSPENSÃO DA PRESTAÇÃO DOS SERVIÇOS ORA CONTRATADOS INDEPENDENTEMENTE DE AVISO OU NOTIFICAÇÃO.

- Responder, com exclusividade, pelos atos praticados por seus prepostos, desenvolvedores de “sites” e/ou “blog”, administradores e/ou por toda e qualquer pessoa que venha a ter acesso à senha de administração dos “sites” e/ou “blog”, declarando-se ciente de que a responsabilidade pelos atos praticados será, sempre, única e exclusiva dele USUÁRIO, que responderá regressivamente em caso de condenação da BADABUM, ficando facultada, inclusive, a denunciação da lide, quando for o caso.

- Comunicar previamente à BADABUM quaisquer circunstâncias previsíveis que possam sujeitar os sites e/ou “blog” hospedado a uma carga não usual de demanda de visitação, tais como, mas não restritas a: campanha publicitária pela mídia, lançamento de novos produtos, etc., SOB PENA DE IMEDIATA SUSPENSÃO DA PRESTAÇÃO DOS SERVIÇOS ORA CONTRATADOS INDEPENDENTEMENTE DE AVISO OU NOTIFICAÇÃO, em razão dessa ocorrência colocar em risco o regular funcionamento do servidor.

- O USUÁRIO deverá utilizar imagens, sons, programas e arquivos onde deverá ser respeitado o direito autoral, material, de imagem, intelectual, de patente e de propriedade, sendo que o USUÁRIO se responsabiliza civil e criminalmente, de forma exclusiva, pela indevida utilização de material de terceiros. Caso a BADABUM seja notificada extrajudicialmente sobre a violação de direito autoral, material, de imagem, de patente e de propriedade por parte do USUÁRIO, este último será cientificado da mesma e, caso, no prazo máximo de 72 (setenta e duas) horas contado da sua cientificação não obtenha ordem judicial que autorize a continuidade da veiculação do “site” impugnado o mesmo será retirado do ar independentemente de novo aviso ou notificação.

- Sem prejuízo das obrigações acima elencadas, comuns a todos os tipos de contratação, responder pelas demais obrigações específicas a determinadas opções contratuais, nos termos do presente contrato.

6 - OBRIGAÇÕES DA BADABUM

- Prestar o serviço objeto do presente, zelando pela eficiência e regular funcionamento do servidor compartilhado adotando junto a cada um dos usuários todas as medidas necessárias para evitar prejuízos ao funcionamento do mesmo.

- Fornecer suporte técnico ao USUÁRIO consistente na execução do presente contrato.

- Fica a BADABUM autorizada a acessar os arquivos existentes na área de hospedagem sempre que esse acesso for necessário e/ou conveniente para a prestação do suporte técnico de responsabilidade da BADABUM.

- Informar ao USUÁRIO, com 3 (três) dias de antecedência, sobre as interrupções necessárias para ajustes técnicos ou manutenção que demandem mais de 6 (seis) horas de duração e que possam causar prejuízo à operacionalidade do site hospedado.

- As manutenções a serem informadas são única e exclusivamente aquelas que interfiram com a operacionalidade do site hospedado, ficando dispensadas informações prévias sobre interrupções, por motivos técnicos de serviços acessórios que não impliquem em prejuízo para a operacionalidade do site hospedado.

- A BADABUM não terá a obrigação de informar previamente ao USUÁRIO sobre as interrupções necessárias em caso de urgência, assim entendidas aquelas que coloquem em risco o regular funcionamento do servidor compartilhado e aquelas determinadas por motivo de segurança da totalidade dos usuários contra vulnerabilidades detectadas assim que isto ocorra, interrupções estas que perdurarão pelo tempo necessário à supressão dos problemas.

- Informar ao USUÁRIO sobre eventual prejuízo causado ou que possa ser causado ao servidor por seus programas e/ou conteúdos armazenados.

- Manter política de proteção contra invasão por “Crackers”, não sendo, no entanto, responsável em caso de ataques inevitáveis pela superação da tecnologia disponível no mercado.

- Caso a BADABUM venha a constatar que a(s) senha(s) utilizada pelo USUÁRIO se encontra(m) abaixo dos níveis mínimos de segurança recomendáveis, fica ela autorizada a bloquear a utilização da senha insegura, independentemente de prévio aviso ou notificação, Nessa hipótese o USUÁRIO será comunicado, posteriormente ao bloqueio para que cadastre uma nova senha, persistindo o bloqueio até que a nova senha atinja níveis seguros recomendáveis.

- Retirar imediatamente do ar o “site” hospedado, caso receba denúncia de que o mesmo está sendo utilizado, mesmo que sem o conhecimento do USUÁRIO, para práticas ilícitas ou desautorizadas por qualquer meio que possibilite fraudes, comunicando esse fato, de imediato, ao USUÁRIO, a fim de que o mesmo possa adotar as medidas tendentes a evitar a possibilidade dessas práticas.

7 – DO DOMÍNIO PERANTE O NÚCLEO DE INFORMAÇÃO E COORDENAÇÃO DO PONTO BR – NIC.br (REGISTRO.BR)

Registro e Manutenção de Domínio Novo

A BADABUM será responsável pelo registro e manutenção dos novos domínios criados pelo USUÁRIO através do website badabum.com.br. A BADABUM somente será responsável pela manutenção desses novos domínios, durante o prazo de vigência do presente contrato.

O Usuário somente poderá criar domínios através do website badabum.com.br, que sejam homologados pelo NÚCLEO DE INFORMAÇÃO E COORDENAÇÃO DO PONTO BR – NIC.br (Registro.BR).

Qualquer domínio que não seja homologado pelo NÚCLEO DE INFORMAÇÃO E COORDENAÇÃO DO PONTO BR – NIC.br (Registro.BR), não será de responsabilidade da BADABUM, ficando o registro e manutenção sob a responsabilidade, única e exclusiva, do USUÁRIO.

O domínio criado pelo USUÁRIO através do website badabum.com.br será de propriedade do USUÁRIO.

Ao termino do contrato, informamos por correio eletrônico todas as informações necessárias sobre o domínio para o USUÁRIO.

A BADABUM não se responsabiliza pela garantia de compra de um domínio enquanto o USUÁRIO não efetuar o pagamento do plano escolhido e o mesmo ser reconhecido pelo sistema da BADABUM, ou seja, o domínio somente será registrado em nome do USUÁRIO, no momento em que o sistema da BADABUM reconhecer o pagamento do plano escolhido pelo USUÁRIO.

Manutenção de Domínio existente

A BADABUM somente será responsável pela administração do domínio cadastrado perante o NÚCLEO DE INFORMAÇÃO E COORDENAÇÃO DO PONTO BR – NIC.br (Registro.BR), durante a vigência deste contrato.

O USUÁRIO é responsável pela transferência dos servidores de hospedagem referentes ao seu domínio. Ao contratar os serviços da BADABUM, o USUÁRIO terá que realizar essa configuração em seu domínio.

8 - CONTRATO CELEBRADO POR TERCEIRO NÃO TITULAR DO REGISTRO DE DOMÍNIO NO ÓRGÃO COMPETENTE
Caso o USUÁRIO não seja titular do domínio do site ora hospedado no competente órgão de registro, declara ele sob as penas da lei civil e criminal manter relação jurídica contratual com o titular do domínio que lhe permita hospedar em nome próprio o Website objeto deste contrato.

Apenas o USUÁRIO terá, em regra, acesso à senha de administração do “site”.

Declara o USUÁRIO ter conhecimento e concordar com o fato de que, caso haja rompimento, por qualquer forma, da relação jurídica entre ele USUÁRIO e o titular do domínio, a BADABUM após requisição por escrito do titular do domínio e desde que comprovada esta condição, não poderá impedir que este tenha acesso ao conteúdo do site hospedado e disponibilidade do mesmo, caso em que a BADABUM fornecerá a senha de administração ao detentor do nome de domínio.

Declara o USUÁRIO, assumir plena e irrestrita responsabilidade perante a BADABUM por qualquer prejuízo a esta causado em decorrência do relacionamento dele USUÁRIO com o titular do domínio do website, obrigando-se a responder regressivamente à BADABUM, caso a mesma venha a ser acionada em razão de eventos dessa natureza.

Declara, mais, o USUÁRIO, assumir plena e irrestrita responsabilidade perante o titular do domínio do website, por prejuízos a este causados, caso o website seja retirado do ar em razão da infração por ele USUÁRIO das cláusulas e condições do presente contrato, obrigando-se a responder regressivamente à BADABUM, caso a mesma venha a ser acionada em razão de eventos dessa natureza.

9 - DA RETIRADA DO SITE DO AR A PEDIDO DE AUTORIDADES

Declara o USUÁRIO ter conhecimento de que em caso de ordem judicial para a suspensão da veiculação do website hospedado por força do presente contrato a mesma será cumprida independentemente de prévia cientificação a ele USUÁRIO.

Na hipótese de solicitação de retirada do “site” do ar formulada por qualquer autoridade pública não judicial de proteção de consumidores, infância e juventude, economia popular ou de qualquer outro interesse público, difuso ou coletivo juridicamente tutelado ou de qualquer outra legitimada a tanto, o USUÁRIO será cientificado da mesma e, caso, no prazo máximo de 72 (setenta e duas) horas contado da sua cientificação não obtenha ordem judicial que autorize a continuidade da veiculação do “site” impugnado o mesmo será retirado do ar independentemente de novo aviso ou notificação.

10 - SIGILO E CONFIDENCIALIDADE

As partes acordam que as informações constantes do website ora hospedado, e dos bancos de dados utilizados pelo USUÁRIO estão cobertos pela cláusula de sigilo e confidencialidade, não podendo a BADABUM, ressalvados os casos de ordem e/ou pedido e/ou determinação judicial de qualquer espécie e/ou de ordem e/ou pedido e/ou determinação de autoridades públicas a fim de esclarecer fatos e/ou circunstâncias e/ou instruir investigação, inquérito e/ou denúncia em curso, revelar as informações a terceiros.

A BADABUM não será responsável por violações dos dados e informações acima referidas resultantes de atos de funcionários, prepostos ou de pessoas autorizadas pelo USUÁRIO e nem daquelas resultantes da ação criminosa ou irregular de terceiros (“hackers”) fora dos limites da previsibilidade técnica do momento em que a mesma vier a ocorrer.

11 - DA RESCISÃO

A Rescisão do contrato se dará com o término do plano escolhido pelo USUÁRIO, eis que não existe a renovação automática do plano.

O USUÁRIO deverá em até 24 (vinte e quatro) horas antes do término do seu plano, optar por um dos planos oferecidos pela BADABUM, para que ocorra a renovação e/ou continuação de vigência do presente contrato.

A rescisão antecipada do contrato por escolha do USUÁRIO lhe dará o direito ao reembolso parcial e proporcional à utilização do serviço. Além do mais, o USUÁRIO pagará uma multa equivalente à 20% (vinte por cento) incidente sobre valor equivalente ao tempo restante para o término do contrato.

É, também, causa de rescisão de pleno direito do presente, mediante simples comunicação escrita por parte da BADABUM e independentemente de prévio aviso ou notificação, o não cumprimento por quaisquer das obrigações assumidas neste contrato.

A suspensão da prestação do serviço e/ou rescisão antecipada do contrato, em decorrência de violação do disposto no presente contrato pelo USUÁRIO, não dará a este o direito ao reembolso e/ou ressarcimento dos valores pagos, e nem excluirá a sua responsabilidade pelos danos causados à BADABUM e/ou terceiros.

12 - DA MANUTENÇÃO DE DADOS

Deixando de vigorar o presente contrato, em qualquer hipótese, por liberalidade e sem qualquer custo para o USUÁRIO, a BADABUM, independentemente de haver retirado o site hospedado do ar, manterá armazenados a última versão dos dados componentes do website, pelo período máximo de 6 meses a contar da data da rescisão do contrato.

A manutenção dos dados do website armazenados pela BADABUM não permitirá o acesso de terceiros e somente permitirá o seu acesso ao USUÁRIO, quando ele restabelecer o vínculo contratual, com a contratação de algum plano válido perante a BADABUM.

Findo o prazo de 6 meses dias ora estabelecido, o apagamento (deleção) dos dados se dará independentemente de qualquer aviso ou notificação, operando-se de forma definitiva e irreversível.

Os Logs de registro dos usuários deverão ser arquivados por pelo menos 3 (três) anos, para fins cíveis e criminais.

13 - COMUNICAÇÃO ENTRE AS PARTES

Os contatos e/ou simples comunicação entre as partes ora USUÁRIO para tudo o que seja decorrente do presente contrato se fará por correio eletrônico, meio esse aceito por ambas como veiculo de comunicação hábil para essa finalidade.

O endereço eletrônico de contato para cada uma das partes será aquele constante do cadastro realizado pelo USUÁRIO.

14 - DOS CONTEÚDOS DIVULGADOS PELO USUÁRIO

O USUÁRIO é o único responsável por toda e qualquer informação, fato, opinião, comentário, crítica, imagem, mensagem, notícia, som, obra musical, literária , marca, ou qualquer outra protegida pela legislação de direito intelectual, oferta comercial de produtos e/ou de serviços que forem formuladas e/ou transitarem e/ou permanecerem, a qualquer título, no seu website, sejam inseridas pelo USUÁRIO e/ou por terceiros.

15 – DA UTILIZAÇÃO DOS CONTEÚDOS FORNECIDOS PELA BADABUM

A BADABUM pode oferecer ao USUÁRIO a possibilidade de incorporar no conteúdo por ele criado dentro do website www.badabum.com.br, imagens, animações, vídeos, áudio, fontes e outros conteúdos pertencentes à BADABUM e/ou fornecidos por terceiros através da BADABUM.

A BADADBUM terá ter o direito, a qualquer momento, e a seu critério exclusivo de: (i) remover do Website da www.badabum.com.br e/ou desativar o acesso a tal Conteúdo de Terceiros; ou (ii) exigir que você remova imediatamente tal Conteúdo de Terceiro de qualquer website ou outra plataforma da web criada e/ou publicada por você no Website www.badabum.com.br.

Se você não obedecer a tais instruções e não remover o Conteúdo de Terceiro do seu Conteúdo dentro de não mais do que 24 horas do momento em que tal procedimento foi solicitado, a BADAABUM TERÁ O DIREITO DE DESATIVAR O ACESSO À TAL CONTEÚDO E/OU EXCLUÍ-LO A SEU CRITÉRIO EXCLUSIVO, SEM RESPONSABILIZAÇÃO PARA A BADABUM.

As imagens, animações, vídeos, áudio, fontes e outros conteúdos pertencentes à BADABUM e/ou fornecidos por terceiros através da BADABUM, não poderá: (i) ser objeto de nenhuma medida de engenharia reversa, descompilação ou desmontagem de modo que permita que o USUÁRIO façam o download de tal Conteúdo; (ii) ser objeto de modificações, duplicatas, distribuição, sublicenciamento, retransmissão, reprodução, criação de trabalhos derivados, transfência, venda, cessão ou fazer outro uso de qualquer Conteúdo, exceto conforme especificamente fornecido e permitido pela BADABUM.

16 - AUTORIZAÇÃO PARA UTILIZAÇÃO DA MARCA E NOME COMERCIAL DO USUÁRIO PARA FINS COMERCIAIS

O USUÁRIO CONCORDA E AUTORIZA a divulgação, gratuita, durante a vigência do presente contrato de prestação de serviços, do seu nome comercial (nome fantasia) e marca da empresa (logotipo), por meio de: a) materiais institucionais impressos, tais como mas não restritos a propostas comerciais da BADABUM, b) materiais digitais e mídias eletrônicas, tais como apresentações digitais, vídeos, e “site” da BADABUM, e, c) materiais e ações publicitárias diversas.

Caso a rescisão do presente contrato ocorra após a impressão de materiais, o nome e marca da USUÁRIO poderão ser usados até o término dos materiais já impressos ou no prazo de 1 (um) ano contado da rescisão, o que ocorrer primeiro.

O USUÁRIO declara-se ciente de que o uso do seu nome e marca será feito a critério exclusivo da BADABUM, apenas e tão somente quando este entender conveniente.

17 - DAS DISPOSIÇÕES GERAIS

A BADABUM poderá alterar, a qualquer tempo, este Termo de Uso, sendo que as novas disposições somente terão validade e eficácia após a divulgação do novo Termo de Uso no website www.badabum.com.br. O USUÁRIO deverá comunicar a BADABUM por meio eletrônico, caso não concorde com o Termo de Uso alterado, solicitando a rescisão e cancelamento do seu cadastro como USUÁRIO.

Não havendo manifestação pelo USUÁRIO, entender-se-á que o USUÁRIO aceitou tacitamente o novo Termo de Uso e o contrato continuará vinculando as partes.

Estes Termos de Uso são regidos pelas leis da República Federativa do Brasil.

As partes elegem o foro da cidade de São Paulo para dirimir todas as dúvidas ou litígios resultantes da execução do presente.

São Paulo, BADABUM SOLUÇÕES DIGITAIS LTDA</textarea>
                        </div>
                        <div class="row text-center text-danger">
                            <p>   Aceito os termos do contrato e reconheço como verdadeiras as informações constantes nesse anuncio e desde logo, 
                                responsabiliza-se integralmente pela veracidade e exatidão das informações aqui fornecidas, sob pena de incorrer nas sanções 
                                previstas no art. 299 do Decreto Lei 2848/40 (Código Penal). </p>
                        </div>
                    </div>
                    <div class="step-pane" id="step5"></div>
                </div>
                <button id="btnWizardPrev" type="button" class="btn btn-warning btn-prev"> <span class="glyphicon glyphicon-chevron-left"></span> Voltar </button>
                <button id="btnWizardNext" type="button" class="btn btn-primary btn-next" data-last="Fim" > Avançar <span class="glyphicon glyphicon-chevron-right"></span></button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {

        $('.alert').hide();

        // Associa o evento do popover ao clicar no link.
        $("#popover").popover({
            trigger: 'hover',
            html: true,
            placement: 'auto',
            content: $('#div-popover').html()
        }).click(function(e) {
            e.preventDefault();
            // Exibe o popover.
            $(this).popover('show');
        });


        $('#MyWizard').on('change', function(e, data) {
            if (data.direction === 'next') {
                if (data.step === 1) {
                    if (!$("#txtCodigo").valid())
                        return e.preventDefault();
                }
                if (data.step === 2) {
                    if (!($("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid()))
                        return e.preventDefault();
                }
                if (data.step === 4) {
                    if (($("#txtCodigo").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid()))
                        $("#form").submit();
                }
            }
        });
        $('#MyWizard').on('changed', function(e, data) {
            var item = $('#MyWizard').wizard('selectedItem');
            if (item.step === 2) {
                var endereco = "<?php echo $endereco; ?>";
                //######### INICIO DO CEP ########
                map = new GMaps({
                    div: '#map',
                    lat: 0,
                    lng: 0
                });
                GMaps.geocode({
                    address: endereco.trim(),
                    callback: function(results, status) {
                        console.log(map);
                        if (status == 'OK') {
                            var latlng = results[0].geometry.location;
                            map.setCenter(latlng.lat(), latlng.lng());
                            map.addMarker({
                                lat: latlng.lat(),
                                lng: latlng.lng()
                            });
                        }
                    }
                });
            }
            if (item.step === 3) {
                $("#colReferencia").click(function() {
                    $('#myModal').modal('show');
                })

                $("#colVoucher").html($("#txtCodigo").val());
                $("#colTitulo").html($("#txtTitulo").val());
                $("#colDescricao").html($("#txtDescricao").val());
                $("#colValor").html($("#txtValor").val());
                $("#colMapa").html($("input[name=rdbMapa]:checked").val());
                var varCampos = new Array();
                $('#sltCamposVisiveis :selected').each(function() {
                    if ($(this).val() != "multiselect-all")
                        varCampos.push($(this).text());
                })
                $("#colCampos").html("&bullet; " + varCampos.join("<br /> &bullet; "));

            }
        });
        //$('#MyWizard').on('finished', function(e, data) {
        //    console.log('finished');
        //});
        $('#btnWizardPrev').on('click', function() {
            $('#MyWizard').wizard('previous');
        });
        $('#btnWizardNext').on('click', function() {
            $('#MyWizard').wizard('next');
        });
        //$('#btnWizardStep').on('click', function() {
        //  var item = $('#MyWizard').wizard('selectedItem');
        //console.log(item.step);
        //});
        //$('#MyWizard').on('stepclick', function(e, data) {
        //    console.log('step' + data.step + ' clicked');
        //    if (data.step === 1) {
        //        // return e.preventDefault();
        //    }
        //});
        // optionally navigate back to 2nd step
        //$('#btnStep2').on('click', function(e, data) {
        //    $('[data-target=#step2]').trigger("click");
        //});

        $('#form').validate({
            rules: {
                txtCodigo: {
                    required: true,
                    minlength: 8
                },
                txtTitulo: {
                    required: true,
                    minlength: 10
                },
                txtDescricao: {
                    required: true,
                    minlength: 10
                },
                txtValor: {
                    required: true
                },
                chkAceite: {
                    required: true
                }
            },
            messages: {
                chkAceite: {
                    required: "Obrigatório"
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function() {
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#form').serialize(),
                    beforeSend: function() {
                        $('.alert').show();
                        $('button').attr('disabled', 'disabled');
                    },
                    success: function(resposta) {
                        $(".alert").hide();
                        if (resposta.resultado == 1) {
                            $("#step5").html('<div class="row text-success">\n\
                                              <h2 class="text-center">Congratulações!</h2>\n\
                                              <p class="text-center">O cadastro de seu anúncio foi concluído com sucesso. </p>\n\
                                              <p class="text-center">Em breve você receberá um e-mail confirmando a publicação do mesmo. </p>\n\
                                              <p class="text-center">Não perca tempo clique aqui e compre mais anúncios! </p>\n\
                                              <p class="text-center">Divulgue esse anuncio no Facebook </p>\n\
                                              </div>');
                        } else {
                            $("#step5").html('<div class="row text-danger">\n\
                                              <h2 class="text-center">Tente novamente mais tarde!</h2>\n\
                                              <p class="text-center">Houve um erro no processamento de cadastro. </p>\n\
                                              </div>');
                            $('button').removeAttr('disabled');
                        }
                    }
                })
                return false;
            }
        })

        $('#txtDescricao').maxlength({
            alwaysShow: true,
            threshold: 100,
            warningClass: "label label-success",
            limitReachedClass: "label label-danger",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#sltCamposVisiveis').multiselect({
            buttonClass: 'btn btn-default btn-sm',
            includeSelectAllOption: true
        });

    });
</script>