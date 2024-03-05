<template>
  <div class="space-y-10">
    <Heading as="h2" class="!text-4xl underline">Basic Elements</Heading>

    <div class="space-y-5">
      <Heading as="h3" class="font-semibold underline">Headings</Heading>
      <Heading as="h1">H1 - Lorem ipsum dolor sit amet, consectetur adipiscing elit.</Heading>
      <Heading as="h2">H2 - Lorem ipsum dolor sit amet, consectetur adipiscing elit.</Heading>
      <Heading as="h3">H3 - Lorem ipsum dolor sit amet, consectetur adipiscing elit.</Heading>
      <Heading as="h4">H4 - Lorem ipsum dolor sit amet, consectetur adipiscing elit.</Heading>
    </div>

    <div class="space-y-5">
      <Heading as="h3" class="font-semibold underline">Buttons</Heading>
      <div class="flex gap-x-4">
        <Button variant="primary">Primary</Button>
        <Button variant="secondary">Secondary</Button>
        <Button variant="outline">Outline</Button>
        <Button variant="disabled">Disabled</Button>
      </div>
    </div>

    <div class="space-y-3">
      <Heading as="h3" class="font-semibold underline">Modals</Heading>
      <p class="">Click the button to show Modal.</p>
      <Button @click="isModalShown = true">Click me</Button>

      <Modal
        :show="isModalShown"
        title="I am a Modal"
        wrapper-class="lg:max-w-[700px]"
        @close="isModalShown = false"
        @confirm="isModalShown = false"
      >
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent maximus bibendum nisi
          tincidunt bibendum. Pellentesque erat lorem, tincidunt quis lacus eget, suscipit imperdiet
          velit. Maecenas aliquam tortor quam, sed tincidunt turpis tristique non. Donec ultricies
          ultrices lacus ut ullamcorper. Vestibulum nisi erat, malesuada in sem in, consectetur
          rhoncus arcu.
        </p>
      </Modal>
    </div>

    <div class="space-y-3">
      <Heading as="h3" class="font-semibold underline">Alerts</Heading>
      <p class="">Click the button to show Alert.</p>
      <Button @click="isAlertShown = true">Click me</Button>

      <Alert :show="isAlertShown" @close="isAlertShown = false" @confirm="isAlertShown = false" />
    </div>

    <div class="space-y-2">
      <Heading as="h3" class="font-semibold underline">Cards</Heading>
      <Card>
        <Heading as="h2" class="mb-3">Heading</Heading>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent maximus bibendum nisi
          tincidunt bibendum. Pellentesque erat lorem, tincidunt quis lacus eget, suscipit imperdiet
          velit. Maecenas aliquam tortor quam, sed tincidunt turpis tristique non. Donec ultricies
          ultrices lacus ut ullamcorper. Vestibulum nisi erat, malesuada in sem in, consectetur
          rhoncus arcu.
        </p>
      </Card>
    </div>

    <div class="space-y-5">
      <Heading as="h3" class="font-semibold underline">HeroIcons</Heading>
      <div class="flex gap-x-5 text-center text-[10px] leading-[1.3]">
        <div class="flex flex-col gap-y-1 items-center">
          <CubeIconOutline class="w-8" /> <span>CubeIcon<br />Outline</span>
        </div>
        <div class="flex flex-col gap-y-1 items-center">
          <EnvelopeIconOutline class="w-8" /> <span>EnvelopeIcon<br />Outline</span>
        </div>
        <div class="flex flex-col gap-y-1 items-center">
          <FolderIconOutline class="w-8" /> <span>FolderIcon<br />Outline</span>
        </div>
        <div class="flex flex-col gap-y-1 items-center">
          <HomeIconOutline class="w-8" /> <span>HomeIcon<br />Outline</span>
        </div>
      </div>
      <div class="flex gap-x-5 text-center text-[10px] leading-[1.3]">
        <div class="flex flex-col gap-y-1 items-center">
          <CubeIconSolid class="w-8" /> <span>CubeIcon<br />Solid</span>
        </div>
        <div class="flex flex-col gap-y-1 items-center">
          <EnvelopeIconSolid class="w-8" /> <span>EnvelopeIcon<br />Solid</span>
        </div>
        <div class="flex flex-col gap-y-1 items-center">
          <FolderIconSolid class="w-8" /> <span>FolderIcon<br />Solid</span>
        </div>
        <div class="flex flex-col gap-y-1 items-center">
          <HomeIconSolid class="w-8" /> <span>HomeIcon<br />Solid</span>
        </div>
      </div>
    </div>

    <div class="space-y-2">
      <Heading as="h3" class="font-semibold underline">Loaders</Heading>
      <Loading placement="internal" class="!w-[80px]" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Card, Heading, Button, Modal, Alert, Loading } from '@/components/common'
import {
  CubeIcon as CubeIconOutline,
  EnvelopeIcon as EnvelopeIconOutline,
  FolderIcon as FolderIconOutline,
  HomeIcon as HomeIconOutline
} from '@heroicons/vue/24/outline'
import {
  CubeIcon as CubeIconSolid,
  EnvelopeIcon as EnvelopeIconSolid,
  FolderIcon as FolderIconSolid,
  HomeIcon as HomeIconSolid
} from '@heroicons/vue/24/solid'

const isModalShown = ref(false)
const isAlertShown = ref(false)
</script>
