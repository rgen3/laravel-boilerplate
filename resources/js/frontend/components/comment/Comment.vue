<template>
  <div class="comment-wrapper">
    <comment-list
      :initial-items="commentList"
      :model-id="modelId"
    ></comment-list>
    <h3>Write a comment</h3>
    <div class="bg-light">
      <Editor
        v-if="$app.user"
        ref="editor"
        @input="updateComment"
        @save="saveNewComment"
        :show-cancel-btn="false"
        :text="text"
      ></Editor>
      <b-alert v-else show variant="info">Please, login to write a comment</b-alert>
    </div>
  </div>
</template>
<script>
import Editor from './Editor'

export default {
  name: 'CommentComponent',
  components: { Editor },
  props: {
    modelId: {
      type: Number,
      required: true
    },
    initialComments: {
      type: Array,
      default: () => []
    }
  },
  data: function() {
    return {
      commentList: this.initialComments,
      newCommentObject: null,
      text: ''
    }
  },
  methods: {
    updateComment: function(data) {
      this.newCommentObject = data
    },
    saveNewComment: function() {
      if (!this.newCommentObject) {
        return
      }

      const commentData = {
        modelId: this.modelId,
        html: this.newCommentObject.html,
        json: this.newCommentObject.json
      }

      this.$store.dispatch('CREATE_COMMENT', commentData).then(response => {
        const comment = { itemClass: 'new-item', ...response.data.comment }
        this.commentList.push(comment)
        this.newCommentObject = null
        this.text = ''
        this.$refs.editor.clearContent()
      })
    }
  }
}
</script>
