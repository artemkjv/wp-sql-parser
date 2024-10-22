<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Create from "@/Pages/Dumps/Modals/Create.vue";
import Export from "@/Pages/Dumps/Modals/Export.vue";

defineProps({
    dumps: {
        type: Array,
        required: true,
    },
    exportTypes: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Dumps" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dumps
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <div class="flex justify-between items-center">
                        <h3
                            class="text-lg font-semibold leading-tight text-gray-800"
                        >
                            Dumps
                        </h3>
                        <div class="gap-4 flex">
                            <Create />
                            <Export :export-types="exportTypes" :dumps="dumps" />

                        </div>
                    </div>

                    <div class="mt-6">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        ID
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(dump, index) in dumps"
                                    :key="index"
                                    class="border-t border-gray-200"
                                >
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                    >
                                        {{ index + 1 }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                    >
                                        {{ dump }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <Dropdown class="float-left">
                                            <template #trigger>
                                                <button
                                                    class="text-gray-600 hover:text-gray-900"
                                                >
                                                    Actions
                                                </button>
                                            </template>
                                            <template #content>
                                                <DropdownLink as="delete" :href="route('dumps.destroy', {'name': dump})" method="delete">
                                                    Delete
                                                </DropdownLink>
                                            </template>
                                        </Dropdown>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
