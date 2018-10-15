<template>
  <ul :class="getClass()">
    <comment-item
      v-for="item in items"
      :key="item.id"
      :item="item"
      :level="level"
      :base-comment-id="baseCommentId || item.id"
      :parent-comment-id="item.id"
      :editor-comment-id="editorCommentId"
      :can-edit="item.canEdit"
      :model-id="modelId"
    ></comment-item>
  </ul>
</template>
<script>
export default {
  name: 'CommentList',
  props: {
    initialItems: {
      type: Array,
      default: () => []
    },
    children: {
      type: Array,
      default: null
    },
    level: {
      type: Number,
      default: 0
    },
    baseCommentId: {
      type: Number,
      default: undefined
    },
    modelId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      items: this.children || this.initialItems,
      editorCommentId: null
    }
  },
  methods: {
    getClass: function() {
      if (this.level > 0) {
        return 'list-unstyled ml-4'
      } else {
        return 'list-unstyled'
      }
    }
  }
}
</script>
