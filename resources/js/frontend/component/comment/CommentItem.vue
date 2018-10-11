<template>
  <li class="my-3">
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
      </span>
    </header>
    <section>
      {{ item.text }} - baseCommentId: {{ baseCommentId }} - parentCommentId: {{ parentCommentId }}
    </section>
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
