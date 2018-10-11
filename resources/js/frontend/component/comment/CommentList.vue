<template>
  <ul :class="getClass()">
    <comment-item
      v-for="item in items"
      :key="item.id"
      :item="item"
      :level="level"
      :base-comment-id="baseCommentId || item.id"
      :parent-comment-id="item.id"
    ></comment-item>
  </ul>
</template>
<script>
const tempItems = [
  {
    id: 112333,
    text: 'this is the text',
    children: [
      {
        id: 22322,
        text: 'this is the children',
        children: [
          {
            id: 111234,
            text: 'this is the text'
          },
          {
            id: 11234487,
            text: 'this is the text'
          }
        ]
      },
      {
        id: 22312,
        text: 'this is the children',
        children: [
          {
            id: 12312334,
            text: 'this is the text'
          },
          {
            id: 112123487,
            text: 'this is the text'
          }
        ]
      }
    ]
  },
  {
    id: 245232,
    text: 'this is the children',
    children: [
      {
        id: 11342234,
        text: 'this is the text'
      },
      {
        id: 1123426487,
        text: 'this is the text'
      }
    ]
  }
]

export default {
  name: 'CommentList',
  props: {
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
    }
  },
  data() {
    return {
      items: this.children || tempItems
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
