<script setup lang="ts">

</script>

<template>
  <section class="container mx-auto mt-10">
    <div class="flex flex-wrap ">
      <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 mb-8 px-4" v-for="x in 14" :key="x">
        <div class="rounded overflow-hidden shadow-lg bg-white">
            <img
              class="w-full"
              src="https://bulma.io/assets/images/placeholders/128x128.png"
              alt="Sunset in the mountains"
            />
            <div class="px-6 py-4">
              <div class="font-bold text-xl mb-2">The Coldest Sunset</div>
              <p class="text-gray-700 text-base">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Voluptatibus quia, nulla! Maiores et perferendis eaque,
                exercitationem praesentium nihil.
              </p>
            </div>
            <div class="px-6 pt-4 pb-2">
              <span
                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                >#photography</span
              >
              <span
                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                >#travel</span
              >
              <span
                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                >#winter</span
              >
            </div>
        </div>
      </div>
    </div>
  </section>
</template>
