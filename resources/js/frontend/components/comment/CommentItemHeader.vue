<template>
  <header class="mb-1">
    <b>Rgen3</b>
    <span class="small">
      <time class="mx-2" :datetime="commentTime">{{ commentTime }}</time>
      <a
        :href="'#comment' + commentId"
        id="copyToClipboardBtn"
        @click.prevent="copyCommentLink('copied')"
      >
        <font-awesome-icon
          v-b-tooltip.hover
          title="Comment link"
          :id="getCopyLinkId()"
          class="text-info mx-2"
          :icon="['fa', 'hashtag']"
        ></font-awesome-icon>
      </a>
      <FavouriteIcon
        :checked="isFavourite"
        unchecked-color="#17a2b8"
        url="/favourite/comment"
        :item-id="commentId"
      ></FavouriteIcon>
      <a
        v-if="canEdit"
        href="#"
        @click.prevent="editComment"
      >
        <font-awesome-icon
          v-if="canEdit"
          class="text-info mx-2"
          :icon="['fa', 'edit']"
        ></font-awesome-icon>
      </a>
    </span>
  </header>
</template>
<script>
import FavouriteIcon from '../favourite/FavouriteComment'
export default {
  name: 'CommentItemHeader',
  components: { FavouriteIcon },
  props: {
    commentTime: {
      type: String,
      required: true
    },
    commentId: {
      type: Number,
      required: true
    },
    parentCommentId: {
      type: Number,
      default: null
    },
    isFavourite: {
      type: Boolean,
      required: true
    },
    canEdit: {
      type: Boolean,
      default: false
    }
  },
  data: function() {
    return {}
  },
  methods: {
    getCopyLinkId: function(suffix) {
      return `copyCommentToClipboard-${suffix}-${this.commentId}`
    },
    copyCommentLink: function() {
      try {
        const commentId = `comment-${this.commentId}`
        const offsetTop = window.document.getElementById(commentId).offsetTop
        window.location.hash = commentId
        if (navigator && navigator.clipboard) {
          navigator.clipboard.writeText(window.location.href)
        }
        window.scrollTo(0, offsetTop - 60)
      } catch (err) {
        alert('Oops, unable to copy')
      }

      return false
    },
    editComment: function() {
      this.$store.dispatch('EDIT_COMMENT', this.commentId)
    }
  }
}
</script>
