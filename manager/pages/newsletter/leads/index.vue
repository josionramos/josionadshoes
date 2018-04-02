<template>
  <div>
    <page-header
      title="Newsletter"
      subtitle="Exibindo todos os leads"
    >
      <a href="#" @click.prevent="download" class="button is-primary" :class="{ 'is-loading': exporting }" :disabled="meta.total === 0">
        <b-icon icon="download"/>
        <span>Exportar CSV</span>
      </a>
    </page-header>

    <ui-data-grid
      :data="leads"
      :total="meta.total"
      :loading="loading"
      :per-page="meta.per_page"
      :current-page="meta.current_page"
      @page-change="fetch"
    >
      <template slot-scope="data">
        <!-- NAME -->
        <b-table-column label="Nome">
          {{ data.props.row.name }}
        </b-table-column>

        <!-- E-MAIL -->
        <b-table-column label="E-mail">
          {{ data.props.row.email }}
        </b-table-column>

        <!-- CREATED AT -->
        <b-table-column label="Data de cadatro">
          {{ data.props.row.created_at | datetime }}
        </b-table-column>
      </template>

      <template slot="empty">
        Nenhuma lead cadastrado ainda :/
      </template>
  </ui-data-grid>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        url: process.env.API_BASEURL + '/newsletter/leads/export',
        meta: {},
        leads: [],
        loading: false,
        exporting: false
      }
    },
    head () {
      return {
        title: 'Newsletter'
      }
    },
    async asyncData ({ app: { $axios } }) {
      let { data } = await $axios.get('newsletter/leads')

      return {
        meta: data.meta,
        leads: data.data
      }
    },
    methods: {
      fetch () {
        //
      },

      download () {
        this.exporting = true

        this.$axios.get('newsletter/leads/export').then(response => {
          const url = window.URL.createObjectURL(new Blob([response.data]))
          const link = document.createElement('a')
          link.href = url
          link.setAttribute('download', 'leads.csv')
          document.body.appendChild(link)
          link.click()

          this.exporting = false
        })
      }
    }
  }
</script>
