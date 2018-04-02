<template>
  <div class="data-grid">
    <div v-if="$slots.filter" class="data-grid-filter">
      <div class="field is-grouped">
        <slot name="filter"/>
      </div>
    </div>

    <b-table
      striped
      bordered
      paginated
      backend-pagination
      :data="data"
      :total="total"
      :loading="loading"
      :per-page="perPage"
      :current-page="currentPage"
      @page-change="pageChange"
    >
      <template slot-scope="props">
        <slot :props="props"/>
        <b-table-column v-if="edit || destroy || view" label="Ações" width="110" centered class="td-actions">
          <a
            href="#"
            v-if="edit"
            class="button is-small"
            @click.prevent="$emit('edit', props.index)"
          >
            <b-icon icon="pencil"/>
          </a>
          <a
            href="#"
            v-if="destroy"
            class="button is-danger is-small"
            @click.prevent="$emit('destroy', props.index)"
          >
            <b-icon icon="delete"/>
          </a>
          <a
            href="#"
            v-if="view"
            class="button is-small"
            @click.prevent="$emit('view', props.index)"
          >
            Ver
          </a>
        </b-table-column>
      </template>

      <!-- Empty -->
      <p slot="empty" class="has-text-centered">
        <slot name="empty"/>
      </p>

      <!-- Footer -->
      <template slot="bottom-left">
        <div class="data-grid-footer">
          <slot name="footer"/>
        </div>
      </template>
    </b-table>
  </div>
</template>

<script>
  export default {
    props: {
      data: {
        type: Array,
        required: true
      },
      currentPage: {
        type: Number,
        required: true
      },
      total: {
        type: Number,
        required: true
      },
      loading: {
        type: Boolean,
        default: false
      },
      perPage: {
        type: Number,
        required: true
      },
      edit: {
        type: Boolean,
        default: false
      },
      view: {
        type: Boolean,
        default: false
      },
      destroy: {
        type: Boolean,
        default: false
      }
    },
    methods: {
      pageChange (page) {
        this.$emit('page-change', page)
      }
    }
  }
</script>

<style lang="sass">
  .data-grid
    .b-table .table
      border: none
    &.table-wrapper
      padding: 0
      background: #fff
    .td-actions
      text-align: center
      a:last-child
        margin-left: 10px

  .data-grid-filter
    display: flex
    justify-content: flex-end
    padding: .75rem
    background: #fbfbfb
    border: 1px solid #dbdbdb
    border-bottom: none

  .data-grid-footer
    font-size: .875rem
    color: #999
</style>
