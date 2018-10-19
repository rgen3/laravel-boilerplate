<template>
  <a @click.prevent="toggleFavourite" href="#">
    <font-awesome-icon
      :color="getIconColor()"
      :icon="['fa', 'bookmark']"
    ></font-awesome-icon>
  </a>
</template>
<script>
import favouriteMixin from './mixin'
export default {
  name: 'CommentComment',
  mixins: [favouriteMixin]
}
</script>
