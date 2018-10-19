<template>
  <b-btn @click="toggleFavourite" :title="getTitle">
    <font-awesome-icon
      :icon="icon"
      :color="getIconColor()"
    ></font-awesome-icon>
  </b-btn>
</template>
<script>
import favouriteMixin from './mixin'

export default {
  name: 'AddToFavourite',
  mixins: [favouriteMixin]
}
</script>
