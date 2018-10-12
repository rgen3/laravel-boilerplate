<template>
  <li class="my-3" :id="item.id">
    <header class="mb-1">
      <b>Rgen3</b>
      <span class="small">
        <time class="mx-2" datetime="2008-02-14 20:00">2008-02-14 20:00</time>
        <font-awesome-icon
          class="text-info mx-2"
          :icon="['fa', 'hashtag']"
        ></font-awesome-icon>
        <font-awesome-icon
          class="text-info mx-2"
          :icon="['fa', 'bookmark']"
        ></font-awesome-icon>
        <font-awesome-icon
          class="text-info mx-2 fa-flip-vertical"
          :icon="['fa', 'code-branch']"
        ></font-awesome-icon>
        <font-awesome-icon
          class="text-info mx-2"
          :icon="['fa', 'arrow-circle-down']"
        ></font-awesome-icon>
        <font-awesome-icon
          class="text-info mx-2"
          :icon="['fa', 'arrow-circle-up']"
        ></font-awesome-icon>
        <font-awesome-icon
          class="text-info mx-2"
          :icon="['fa', 'edit']"
        ></font-awesome-icon>
      </span>
    </header>
    <section>
      {{ item.text }} - currentCommentId:  {{ currentCommentId }}; item.id: {{ item.id }} |
    </section>
    <footer class="mt-1">
      <div class="bg-light" v-if="currentCommentId === item.id">
        <Editor></Editor>
      </div>
      <a v-else @click.prevent="setAnswerToComment(item.id)" href="#" class="nav-link-info my-2">answer</a>
    </footer>
    <comment-list
      v-if="item.children"
      :children="item.children"
      :level="level + 1"
      :base-comment-id="baseCommentId"
    ></comment-list>
  </li>
</template>
<script>
import Editor from './Editor'

export default {
  name: 'CommentItem',
  components: { Editor },
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
  },
  data() {
    return {
      comment: ''
    }
  },
  computed: {
    currentCommentId: function() {
      return this.$store.state.comments.currentCommentId
    }
  },
  methods: {
    setAnswerToComment: function(commentId) {
      this.$store.dispatch('SET_CURRENT_COMMENT_ID', commentId)
      return false
    }
  }
}
</script>
