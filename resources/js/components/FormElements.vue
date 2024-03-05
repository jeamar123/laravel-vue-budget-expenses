<template>
  <div class="space-y-10 lg:max-w-[500px]">
    <Heading as="h2" class="!text-4xl underline">Form Elements</Heading>

    <div class="space-y-5">
      <Heading as="h3" class="font-semibold underline">Text</Heading>

      <div class="grid lg:grid-cols-2 gap-5">
        <TextInput label="Text" />

        <TextInput label="Password" type="password" />

        <TextInput label="Number" type="number" />
      </div>
    </div>

    <div class="space-y-5">
      <Heading as="h3" class="font-semibold underline">Textarea</Heading>

      <div class="flex items-center gap-x-5">
        <TextInput as="textarea" label="Address" class="w-full" input-class="h-20" />
      </div>
    </div>

    <div class="space-y-5">
      <Heading as="h3" class="font-semibold underline">Checkbox</Heading>

      <div class="flex items-center gap-x-5">
        <Checkbox id="lorem1" label="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
      </div>
    </div>

    <div class="space-y-5">
      <Heading as="h3" class="font-semibold underline">Radio</Heading>

      <div class="flex flex-col gap-y-5">
        <Radio
          id="lorem2"
          label="Lorem ipsum dolor sit amet, consectetur adipiscing elit."
          name="sample_radio_items"
        />
        <Radio
          id="lorem3"
          label="Lorem ipsum dolor sit amet, consectetur adipiscing elit."
          name="sample_radio_items"
        />
        <Radio
          id="lorem4"
          label="Lorem ipsum dolor sit amet, consectetur adipiscing elit."
          name="sample_radio_items"
        />
      </div>
    </div>

    <div class="space-y-5">
      <Heading as="h3" class="font-semibold underline">Select Dropdown</Heading>

      <SelectDropdown :items="['Apple', 'Banana', 'Carrots', 'Durian']" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Heading } from '@/components/common'
import { TextInput, Checkbox, Radio, SelectDropdown } from '@/components/form'
</script>
