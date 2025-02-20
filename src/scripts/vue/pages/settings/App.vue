<template>
  <div class="">
    <h1>Settings</h1>

    <div class="">
      <h3>Enable page excerpt</h3>

      <base-select
          :options="[
            { label: 'Yes', value: 'yes' },
            { label: 'No', value: 'no' }
          ]"
          :modelValue="'no'"
      />

      <h3>Remove WordPress useless image sizes?</h3>

      <base-select
          :options="[
            { label: 'Yes', value: 'yes' },
            { label: 'No', value: 'no' }
          ]"
          :modelValue="'no'"
      />
    </div>

    <base-button
        @click="initSave()"
    >
      Save
    </base-button>
  </div>
</template>

<script setup>
import {ref} from 'vue'
import superagent from 'superagent'

import BaseButton from '@scripts/vue/components/common/base/Button'
import BaseSelect from '@scripts/vue/components/common/base/Select'

const initSave = () => {
	superagent
		.post("http://1-better.local/wp-json/theme-tweaks/v1/options")
		.catch((err) => {
			console.log(err);
		});
};
</script>

<style lang="scss" scoped>

</style>