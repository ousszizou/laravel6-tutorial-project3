<template>
  <div v-if="form.errors.has(field)" class="text-bold text-red-600" v-html="form.errors.get(field)"/>
</template>

<script>
export default {
  name: 'has-errortailwind',
  props: {
    form: {
      type: Object,
      required: true
    },
    field: {
      type: String,
      required: true
    }
  }
}
</script>
