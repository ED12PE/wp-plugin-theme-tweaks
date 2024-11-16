<template>
  <div class="">
    <tabs
        elevation
        :active="props.active.slug"
        @change="$emit('change', $event)"
    >
      <tab v-for="tab in tabs">
        {{ tab.label }}
      </tab>
    </tabs>

    <tabs-items>
      <tab-item>
        <transition
            name="route-fade"
            mode="out-in"
        >
          <slot/>
        </transition>
      </tab-item>
    </tabs-items>
  </div>
</template>

<script setup>
// import '@varlet/ui/es/tabs/style'
// import '@varlet/ui/es/tab/style'
// import '@varlet/ui/es/tabs-items/style'
// import '@varlet/ui/es/tab-item/style'
import {Tabs, Tab, TabsItems, TabItem} from '@varlet/ui'

const props = defineProps({
  active: Object,
  tabs: Array
})

defineEmits(['change'])
</script>

<style lang="scss" scoped>

</style>