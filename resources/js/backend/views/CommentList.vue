<template>
  <div>
    <b-card>
      <template slot="header">
        <h3 class="card-title">{{ $t('labels.backend.comment.titles.index') }}</h3>
        <div class="card-options" v-if="this.$app.user.can('create comment')">
          <b-button to="/comment/create" variant="success" size="sm">
            <i class="fe fe-plus-circle"></i> {{ $t('buttons.comment.create') }}
          </b-button>
        </div>
      </template>
      <b-datatable ref="datasource"
                   @context-changed="onContextChanged"
                   search-route="admin.comment.search"
                   delete-route="admin.comment.destroy"
                   action-route="admin.comment.batch_action" :actions="actions"
                   :selected.sync="selected"
      >
        <b-table ref="datatable"
                 striped
                 bordered
                 show-empty
                 stacked="md"
                 no-local-sorting
                 :empty-text="$t('labels.datatables.no_results')"
                 :empty-filtered-text="$t('labels.datatables.no_matched_results')"
                 :fields="fields"
                 :items="dataLoadProvider"
                 sort-by="comments.created_at"
                 :sort-desc="true"
        >
          <template slot="HEAD_checkbox" slot-scope="data"></template>
          <template slot="checkbox" slot-scope="row">
            <b-form-checkbox :value="row.item.id" v-model="selected"></b-form-checkbox>
          </template>
          <template slot="body" slot-scope="row">
            {{ row.item.body }}
          </template>
          <template slot="users.name" slot-scope="row">
            <span>{{ row.item.name }}</span>
          </template>
          <template slot="comments.status" slot-scope="row">
            <b-badge :variant="row.item.state">{{ row.item.state }}{{ $t(row.item.status_label) }}</b-badge>
          </template>
          <template slot="comments.deleted_at" slot-scope="row">
            {{ row.item.deleted_at }}
          </template>
          <template slot="comments.created_at" slot-scope="row">
            {{ row.item.created_at }}
          </template>
          <template slot="comments.updated_at" slot-scope="row">
            {{ row.item.updated_at }}
          </template>
          <template slot="actions" slot-scope="row">
            <b-button size="sm" variant="primary" :to="`/comment/${row.item.id}/edit`" v-b-tooltip.hover :title="$t('buttons.edit')" class="mr-1">
              <i class="fe fe-edit"></i>
            </b-button>
            <b-button size="sm" variant="danger" v-b-tooltip.hover :title="$t('buttons.delete')" @click.stop="onDelete(row.item.id)">
              <i class="fe fe-trash"></i>
            </b-button>
          </template>
        </b-table>
      </b-datatable>
    </b-card>
  </div>
</template>
<script>
import form from '../mixins/form'

export default {
  name: 'CommentList',
  mixins: [form],
  data() {
    return {
      selected: [],
      fields: [
        { key: 'checkbox' },
        { key: 'body', label: this.$t('labels.comment'), class: 'nowrap' },
        { key: 'users.name', label: this.$t('labels.author'), sortable: true },
        {
          key: 'comments.status',
          label: this.$t('validation.attributes.status'),
          class: 'text-center',
          sortable: true
        },
        {
          key: 'comments.created_at',
          label: this.$t('labels.created_at'),
          class: 'text-center',
          sortable: true
        },
        {
          key: 'comments.updated_at',
          label: this.$t('labels.updated_at'),
          class: 'text-center',
          sortable: true
        },
        {
          key: 'comments.deleted_at',
          label: this.$t('labels.deleted_at'),
          class: 'text-center',
          sortable: true
        },
        {
          key: 'actions',
          label: this.$t('labels.actions'),
          class: 'nowrap'
        }
      ],
      actions: {
        destroy: this.$t('labels.backend.comment.actions.destroy')
      }
    }
  },
  methods: {
    dataLoadProvider(ctx) {
      return this.$refs.datasource.loadData(ctx.sortBy, ctx.sortDesc)
    },
    onContextChanged() {
      return this.$refs.datatable.refresh()
    },
    onDelete(id) {
      this.$refs.datasource.deleteRow({ comment: id })
    }
  }
}
</script>
