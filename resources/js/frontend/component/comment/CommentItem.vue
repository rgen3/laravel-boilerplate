<template>
  <li>
    {{ item.text }} - baseCommentId: {{ baseCommentId }} - parentCommentId: {{ parentCommentId }}
    <comment-list
      v-if="item.children"
      :children="item.children"
      :level="level + 1"
      :base-comment-id="baseCommentId"
    ></comment-list>
  </li>
</template>
<script>
export default {
  name: 'CommentItem',
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
    }
  }
}
</script>
