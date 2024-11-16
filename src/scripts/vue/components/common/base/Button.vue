<template>
  <var-button
      type="primary"
      :loading="loading"
  >
    <slot/>
  </var-button>
</template>

<script setup>
import '@varlet/ui/es/button/style'

import {
  Button as VarButton
} from '@varlet/ui'

defineProps({
  loading: Boolean,
})
</script>