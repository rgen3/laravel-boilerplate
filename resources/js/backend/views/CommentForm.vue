<template>
  <div>
    <form @submit.prevent="onSubmit">
      <b-row>
        <b-col xl="8">
          <b-card>
            <h3 class="card-title" slot="header">{{ isNew ? $t('labels.backend.comment.titles.create') : $t('labels.backend.comment.titles.edit') }}</h3>

            <b-form-group
              :label="$t('validation.attributes.categories.parent')"
              label-for="parentCategory"
              horizontal
              :label-cols="2"
            >
              <v-category-select
                :multiple="false"
                v-model="commentOwner"
                :default-categories="model.userForSelect"
                :callback="searchUsers()"
                :close-on-select="true"
              ></v-category-select>
            </b-form-group>

            <b-form-group
              :label="$t('validation.attributes.body')"
              label-for="body"
              horizontal
              :label-cols="2"
            >
              <p-richtexteditor
                name="body"
                v-model="model.body"
              ></p-richtexteditor>
            </b-form-group>

            <b-row slot="footer">
              <b-col md>
                <b-button to="/posts" exact variant="danger" size="sm">
                  {{ $t('buttons.back') }}
                </b-button>
              </b-col>
              <b-col md>
                <input name="status" type="hidden" value="publish">

                <b-dropdown right split :text="$t('buttons.posts.save_and_publish')" class="float-right"
                            variant="success" size="sm" @click="model.status = 'publish'; onSubmit()"
                            :disabled="pending"
                            v-if="isNew || this.$app.user.can('edit posts') || this.$app.user.can('edit own posts')"
                >
                  <b-dropdown-item @click="model.status = 'draft'; onSubmit()">{{ $t('buttons.posts.save_as_draft') }}
                  </b-dropdown-item>
                </b-dropdown>
              </b-col>
            </b-row>
          </b-card>
        </b-col>
        <b-col xl="4">
          <div role="tablist">
            <b-card no-body class="mb-0">
              <b-card-header header-tag="header" role="tab">
                <h5 class="card-title">
                  <a href="#" v-b-toggle.collapseOne>
                    {{ $t('labels.backend.posts.titles.publication') }}
                  </a>
                </h5>
              </b-card-header>
              <b-collapse id="collapseOne" visible accordion="post-accordion" role="tabpanel">
                <b-card-body>
                  <template v-if="!isNew">
                    <div class="form-group">
                      <b-row>
                        <label class="col-lg-3 col-form-label">{{ $t('validation.attributes.status') }}</label>
                        <b-col lg="9">
                          <label class="col-form-label">
                            <b-badge :variant="model.state">{{ $t(model.status_label) }}</b-badge>
                          </label>
                        </b-col>
                      </b-row>
                    </div>
                    <div class="form-group">
                      <b-row>
                        <label class="col-lg-3 col-form-label">{{ $t('labels.author') }}</label>
                        <b-col lg="9">
                          <label class="col-form-label" v-if="model.owner">{{ model.owner.name }}</label>
                          <label class="col-form-label" v-else>{{ $t('labels.anonymous') }}</label>
                        </b-col>
                      </b-row>
                    </div>
                  </template>

                  <div class="form-group">
                    <b-row>
                      <b-col lg="9" offset-lg="3">
                        <c-switch
                          name="pinned"
                          v-model="model.pinned"
                          :description="$t('validation.attributes.pinned')"
                        ></c-switch>
                      </b-col>
                    </b-row>
                  </div>

                  <div class="form-group">
                    <b-row>
                      <b-col lg="9" offset-lg="3">
                        <c-switch
                          name="promoted"
                          v-model="model.promoted"
                          :description="$t('validation.attributes.promoted')"
                        ></c-switch>
                      </b-col>
                    </b-row>
                  </div>
                </b-card-body>
              </b-collapse>
            </b-card>
          </div>
        </b-col>
      </b-row>
    </form>
  </div>
</template>
<script>
import axios from 'axios'
import form from '../mixins/form'

export default {
  name: 'CommentForm',
  mixins: [form],
  data() {
    return {
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: true
      },
      modelName: 'comment',
      resourceRoute: 'comment',
      listPath: '/comment',
      type: null,
      commentOwner: null,
      model: {
        userForSelect: null,
        model_type: null,
        model_id: null,
        body: null,
        parent: null,
        user_id: null,
        owner: null,
        status: null,
        deleted_at: null,
        updated_at: null,
        created_at: null
      }
    }
  },
  watch: {
    commentOwner: function(newValue) {
      console.log(newValue)
    }
  },
  methods: {
    searchUsers() {
      return search => {
        return axios.get(this.$app.route('admin.users.search.ajax'), {
          params: {
            q: search
          }
        })
      }
    }
  }
}
</script>
