<template>
  <li
    class="my-3 item-wrapper"
    :id="'comment-' + item.id"
  >
    <div
      :class="getItemClass()"
    >
      <CommentHeader
        :comment-id="item.id"
        :parent-comment-id="item.parentCommentId"
        :comment-time="item.commentTime"
        :is-favourite="item.isFavourite"
        :can-edit="item.canEdit"
      ></CommentHeader>
      <section>
        <Editor
          v-if="isEditMode"
          :text="item.text"
          :json="item.json"
          @input="updateCommentObject"
          @save="saveEditedComment"
          @cancel="cancelEditMode()"
        ></Editor>
        <div v-else v-html="comment"></div>
      </section>
      <footer class="mt-1">
        <div class="bg-light" v-if="currentCommentId === item.id">
          <Editor
            @input="updatenewCommentObject"
            @save="saveNewComment"
            @cancel="cancelAnswer()"
          ></Editor>
        </div>
        <a v-else @click.prevent="setAnswerToComment(item.id)" href="#" class="nav-link-info my-2">reply</a>
      </footer>
    </div>
    <comment-list
      v-if="children"
      :children="children"
      :level="level + 1"
      :base-comment-id="baseCommentId"
      :model-id="modelId"
    ></comment-list>
  </li>
</template>
<script>
import Editor from './Editor'
import CommentHeader from './CommentItemHeader'

export default {
  name: 'CommentItem',
  components: { Editor, CommentHeader },
  props: {
    item: {
      type: Object,
      required: true
    },
    level: {
      type: Number,
      required: true
    },
    baseCommentId: {
      type: Number,
      required: true
    },
    parentCommentId: {
      type: Number,
      required: true
    },
    modelId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      comment: this.item.text,
      children: this.item.children,
      newCommentObject: null,
      editCommentObject: null
    }
  },
  computed: {
    isEditMode: function() {
      return this.$store.state.comments.editingCommentId === this.item.id
    },
    currentCommentId: function() {
      return this.$store.state.comments.currentCommentId
    }
  },
  methods: {
    getItemClass: function() {
      return this.item.itemClass ? `ml-4 ${this.item.itemClass}` : 'ml-1'
    },
    setAnswerToComment: function(commentId) {
      this.$store.dispatch('SET_CURRENT_COMMENT_ID', commentId)
      return false
    },
    cancelAnswer: function() {
      this.$store.dispatch('SET_CURRENT_COMMENT_ID', null)
    },
    cancelEditMode: function() {
      this.newCommentObject = null
      this.editCommentObject = null
      this.$store.dispatch('EDIT_COMMENT', null)
    },
    updateCommentObject: function(data) {
      this.editCommentObject = data
    },
    updatenewCommentObject: function(data) {
      this.newCommentObject = data
    },
    saveEditedComment: function() {
      if (!this.editCommentObject) {
        this.cancelEditMode()
        return
      }

      const commentData = {
        id: this.item.id,
        data: this.editCommentObject
      }

      this.$store.dispatch('UPDATE_COMMENT', commentData).then(response => {
        this.comment = response.data.comment.text
        this.$store.dispatch('EDIT_COMMENT', null)
      })
    },
    saveNewComment: function() {
      if (!this.newCommentObject) {
        this.cancelEditMode()
        return
      }

      const commentData = {
        modelId: this.modelId,
        parentId: this.item.id,
        html: this.newCommentObject.html,
        json: this.newCommentObject.json
      }

      this.$store.dispatch('CREATE_COMMENT', commentData).then(response => {
        const comment = {
          itemClass: 'new-item',
          ...response.data.comment
        }
        comment.children = []

        this.children.push(comment)
        this.cancelAnswer()
      })
    }
  }
}
</script>
