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
                    <div class="rounded-xl bg-gray-50 border-gray-200 border my-16 mx-8 px-4 py-4">
                        <h2 class="text-lg text-bold border-b border-gray-200 py-2 px-2 mb-2">Add Item To Shopping List</h2>
                        <div class="flex">
                            <div class="w-1/2">
                                <select id="item_id" v-model="form.item_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="0" selected disabled>Please Select</option>
                                    <template v-for="(departmentItems, departmentName) in item_data" :key="departmentName">
                                        <option :value="departmentItems[0].department.id" disabled class="font-bold">{{ departmentItems[0].department.name }}</option>
                                        <option v-for="item_data in departmentItems" :key="item_data.id" :value="item_data.id">{{ item_data.name }}</option>
                                    </template>
                                </select>
                            </div>
                            <div class="w-1/2 flex justify-between px-8">
                                <div class="w-1/4">
                                    <input v-model="form.item_qty" id="item_qty" class='border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full' 
                                    type="number" required placeholder="1" min="1">
                                </div>
                                <div class="w-1/4 flex items-center">
                                    <span @click="submit" class="underline" :class="[quantityClass]">Save</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 my-16 h-screen">
                        <div class="my-8">
                            <template v-for="departmentItems in itemList">
                                <h2 class="bold text-2xl border-b-2 border-gray-50 py-2">{{ departmentItems[0].department.name }}</h2>
                                <template v-for="itemList in departmentItems" :key="itemList.id">
                                    <div class="space-y-4 divide-y divide-y-gray-50">
                                        <li :class="{ 'opacity-25': itemList.purchased === 1 }" class="list-decimal px-8 py-4 flex justify-between items-center">
                                            <div class="w-1/2 flex items-center">
                                                <div class="w-1/2 flex items-center space-x-4">
                                                    <input type="checkbox" id="purchased" name="purchased" :checked="itemList.purchased" @change="updateItem(itemList)">
                                                    <label for="20" class="block">{{ itemList.item.name }}</label>
                                                </div>
                                                <div class="w-1/2">
                                                    <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" 
                                                    id="quantity" type="number" v-model.number="itemList.quantity" @change="updateQty(itemList)" required>
                                                </div>
                                            </div>
                                            <span class="underline cursor-pointer text-xs" @click="destroy(itemList.id)">Delete</span>
                                        </li>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'
import {computed} from "vue";

const props = defineProps({
    item_data: Array,
    itemList: Array
});

const form = useForm({
    item_qty: null,
    item_id: null
});

const submit = () => {
    if (form.item_id && form.item_id !== '0' && form.item_qty && form.item_qty !== 0) {
        
        if (form.isDirty)
            form.post(route('list.store'), {
                item_id: form.item_id,
                item_qty: form.item_qty
            });
    } else {
        if (form.item_id && form.item_id !== '0') {
            const selectElementSelNotEmpty = document.querySelector('#item_id');
            selectElementSelNotEmpty.classList.remove('bg-red-50');
        } else {
            const selectElementSel = document.querySelector('#item_id');
            selectElementSel.classList.add('bg-red-50');
        }

        if (form.item_qty && form.item_qty !== 0) {
            const selectElementQtyNotEmpty = document.querySelector('#item_qty');
            selectElementQtyNotEmpty.classList.remove('bg-red-50');
        } else {
            const selectElementQty = document.querySelector('#item_qty');
            selectElementQty.classList.add('bg-red-50');
        }
    }
};

const quantityClass = computed(() => {
    return form.item_qty <= 0 ? 'cursor-not-allowed text-gray-400' : 'text-gray-black cursor-pointer';
});

const updateItem = (itemList) => {
    const purchased = itemList.purchased === 1 ? 0 : 1;
    axios.put(route('list.update', itemList.id), { purchased })
    .then(() => {
        itemList.purchased = purchased;
    })
    .catch((error) => {
        console.log(error);
    });
};

const updateQty = (itemList) => {
  axios.put(route('list.update', itemList.id), {quantity: itemList.quantity})
    .then(() => {
      console.log();
    })
    .catch((error) => {
      console.log(error);
    });
};

const destroy = (id) => {
    axios.delete(route('list.destroy', id), {
      maxRedirects  : 0
    })
    .then(function(response){
        Inertia.reload();
    })
}
</script>