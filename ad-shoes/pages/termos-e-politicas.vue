<template>
  <div class="container">
    <ui-page-header>
      <h1>Termos e políticas</h1>
    </ui-page-header>

    <div class="row">
      <div class="col-sm-8 col-sm-push-2">
        <p>Este site é de propriedade, mantido, e operado por AD Shoes Ltda, com endereço na Rua Waldemar Wasen 235, Caracol, Canela/RS, inscrita no CNPJ/MF sob o nº 06.015-191/0001-41.</p>

        <p>A empresa disponibilizará no Site, para cada produto, uma página descritiva, da qual constarão informações relativas às suas características, composição, eventuais riscos que possa oferecer à saúde e à segurança, prazo de validade, origem, disponibilidade em estoque, condições de pagamento e preço total à vista.</p>

        <p>Para a aquisição dos produtos, o Cliente deverá acessar sua Conta e seguir as indicações do Site. Feita a escolha dos produtos e de suas respectivas quantidades, o Cliente será direcionado à página de pagamento, para cálculo do frete e escolha da forma de pagamento. Este é o último momento para que o Cliente identifique e corrija quaisquer erros cometidos nas etapas anteriores.</p>

        <p>A AD Shoes Ltda toma todas as medidas necessárias para proteger a privacidade do Usuário, em atendimento à legislação em vigor.</p>

        <ui-page-header>
          <h1>FAQ</h1>
        </ui-page-header>

        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title">
                <a role="button" @click="open" href="#faq-a">Quais são os meios de pagamentos disponíveis?</a>
              </h4>
            </div>
            <div id="faq-a" class="panel-collapse collapse" role="tabpanel" :class="{ in: current === '#faq-a' }">
              <div class="panel-body">No momento,aceitamos apenas cartões de crédito emitidos no Brasil de bandeiras. No futuro, pretendemos adotar outros meios de pagamento. Essas mudanças serão divulgadas em nosso Site e refletidas em nossa Política de Pagamentos.</div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title">
                <a role="button" href="#faq-b" @click="open">E se o meu pagamento não for aprovado?</a>
              </h4>
            </div>
            <div id="faq-b" class="panel-collapse collapse" role="tabpanel" :class="{ in: current === '#faq-b' }">
              <div class="panel-body">Você será notificado em até 48 horas e deverá inserir outro meio de pagamento. Caso contrário, a Compra no Site será cancelada.</div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title">
                <a role="button" href="#faq-c" @click="open">Consigo rastrear a minha Compra?</a>
              </h4>
            </div>
            <div id="faq-c" class="panel-collapse collapse" role="tabpanel" :class="{ in: current === '#faq-c' }">
              <div class="panel-body">Sim. As informações mais atualizadas sobre sua Compra e a situação de entrega de sua Compra estão disponíveis em Meus pedidos. Além disso, você será notificado do andamento do seu pedido pelo e-mail informado.</div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title">
                <a role="button" href="#faq-d" @click="open">Qual a empresa responsável pela entrega da minha Compra?
             </a>
              </h4>
            </div>
            <div id="faq-d" class="panel-collapse collapse" role="tabpanel" :class="{ in: current === '#faq-d' }">
              <div class="panel-body">Neste momento, trabalhamos apenas com as transportadoras Correios.</div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title">
                <a role="button" href="#faq-e" @click="open">Posso adicionar outro produto à Compra que eu fiz?</a>
              </h4>
            </div>
            <div id="faq-e" class="panel-collapse collapse" role="tabpanel" :class="{ in: current === '#faq-e' }">
              <div class="panel-body">Não, após finalizada, a Compra não poderá ser alterada. Para adquirir outro produto, você deverá iniciar uma nova Compra.</div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title">
                <a role="button" href="#faq-f" @click="open">Posso efetuar uma Compra no Site com CNPJ?</a>
              </h4>
            </div>
            <div id="faq-f" class="panel-collapse collapse" role="tabpanel" :class="{ in: current === '#faq-f' }">
              <div class="panel-body">Neste momento, não estamos trabalhando com esta opção. Apenas pessoas físicas podem se cadastrar no Site e efetuar Compras. A aquisição de produtos por meio de CNPJ pode ser feito no Televendas.</div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title">
                <a role="button" href="#faq-g" @click="open">Como faço para confirmar a disponibilidade de um produto no estoque? </a>
              </h4>
            </div>
            <div id="faq-g" class="panel-collapse collapse" role="tabpanel" :class="{ in: current === '#faq-g' }">
              <div class="panel-body">No Site, se houver carrinho de compras visível no momento da finalização do pedido, significa que há estoque do produto.</div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title">
                <a role="button" href="#faq-h" @click="open">Posso fazer minha Compra no Site e buscar os produtos adquiridos na loja física?</a>
              </h4>
            </div>
            <div id="faq-h" class="panel-collapse collapse" role="tabpanel" :class="{ in: current === '#faq-h' }">
              <div class="panel-body">Não. Ao efetuar uma Compra pelo Site, você receberá o(s) produto(s) adquirido(s) no endereço informado, por meio dos mecanismos de entrega disponibilizados pela ADShoes no Site. A respeito, vide a Política de Entrega.</div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title">
                <a role="button" href="#faq-i" @click="open">Qualquer pessoa pode receber o produto que eu comprei</a>
              </h4>
            </div>
            <div id="faq-i" class="panel-collapse collapse" role="tabpanel" :class="{ in: current === '#faq-i' }">
              <div class="panel-body">Sim, desde que seja maior de idade, esteja munido de um documento de identificação e assine o protocolo de entrega.</div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title">
                <a role="button" href="#faq-j" @click="open">Existe um valor mínimo de pedido?</a>
              </h4>
            </div>
            <div id="faq-j" class="panel-collapse collapse" role="tabpanel" :class="{ in: current === '#faq-j' }">
              <div class="panel-body">Não.</div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title">
                <a role="button" href="#faq-k" @click="open">Posso alterar o endereço da entrega?</a>
              </h4>
            </div>
            <div id="faq-k" class="panel-collapse collapse" role="tabpanel" :class="{ in: current === '#faq-k' }">
              <div class="panel-body">Sim, mas somente antes de concluir a Compra no Site. Depois de finalizada, a Compra não pode mais ser alterada. Em caso de dúvida, entre em contato com nossa central de atendimento por telefone 54 99988-2018. </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        current: null
      }
    },
    head () {
      return {
        title: 'Termos e políticas'
      }
    },
    methods: {
      open (e) {
        this.current = e.target.getAttribute('href')
      }
    }
  }
</script>
