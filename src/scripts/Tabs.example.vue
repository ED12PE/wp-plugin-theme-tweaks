<template>
  <div class="">
    <base-tabs
        :tabs="tabs"
        :active="activeTab"
        @change="activeTab = tabs[$event]"
    >
      <div v-if="0 === activeTab.slug">
        11111111
      </div>

      <div v-if="1 === activeTab.slug">
        22222222
      </div>

      <div v-if="2 === activeTab.slug">
        33333333
      </div>
    </base-tabs>
  </div>
</template>

<script setup>
import {ref} from 'vue'

import BaseTabs from '@scripts/vue/components/common/base/Tabs'

const tabs      = [
  {slug: 0, label: 'Tab 1'},
  {slug: 1, label: 'Tab 2'},
  {slug: 2, label: 'Tab 3'}
]
const activeTab = ref(tabs[0])
</script>

<style lang="scss" scoped>

</style>