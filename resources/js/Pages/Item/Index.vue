<template>
    <app-layout>
        <Head title="Item"/>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Items
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-end py-4 px-8">
                        <Link :href="route('items.create')" class="underline cursor-pointer">Create Item</Link>
                    </div>

                    <ol class="px-8 my-16 h-screen space-y-4 divide-y divide-y-gray-50">
                        <template v-for="(department, departmentIndex) in departments">
                            <template v-if="items.find(item => item.department_id === department.id)">
                                <li class="bold text-2xl border-b-2 border-gray-50 py-2">{{ department.name }}</li>
                                <template v-for="(item, itemIndex) in items" :key="item.id">
                                    <li class="list-decimal px-8 py-4 flex justify-between items-center" v-if="item.department_id === department.id">
                                        <Link class="block" :href="route( 'items.show', item)" >{{ item.name }}</Link>
                                        <span class="underline cursor-pointer text-xs" @click="destroy(item.id)">Delete</span>
                                    </li>
                                </template>
                            </template>
                        </template>
                    </ol>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, Head } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import {computed} from "vue";

defineProps({
    items: Array,
    departments: Array
});

const destroy = (id) => {
    axios.delete( route('items.destroy', id), {
      maxRedirects  : 0
    }  )
        .then( function(response){
            Inertia.reload();
        } )
}

</script>
<style scoped>

</style>
