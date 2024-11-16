<template>
  <div class='wrapper'>
    <var-select
        variant='outlined'
        v-model="inputValue"
        @change="$emit('update:modelValue', $event)"
        :options="options"
    />
  </div>
</template>

<script setup>
import {ref} from 'vue'
import '@varlet/ui/es/select/style'
import '@varlet/ui/es/option/style'

import {
  Select as VarSelect
} from "@varlet/ui";

const props = defineProps({
  options: {
    type: Array,
    default: () => []
  },
  modelValue: {
    type: [String, Number],
    default: ''
  }
})

defineEmits(['update:modelValue'])

const inputValue = ref(props.modelValue)
</script>

<style lang="scss" scoped>

</style>