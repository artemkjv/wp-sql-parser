<script setup>

import {ref} from "vue";
import Modal from "@/Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Multiselect from 'vue-multiselect'


const props = defineProps({
    dumps: {
        required: true,
        type: Array
    },
    exportTypes: {
        required: true,
        type: Array
    }
})

const showModal = ref(false)
const form = useForm({
    dumps: [],
    export_type: null
})

const toggleModal = () => {
    showModal.value = !showModal.value
}

const submit = () => {
    form.post(route('dumps.export'), {
        onSuccess: () => {
            form.reset()
            toggleModal()
        },
    })
}
</script>

<template>
    <div>
        <Modal :show="showModal" :closeable="true" @close="toggleModal">
            <slot>
                <div class="px-8 py-4">
                    <form
                        @submit.prevent="submit"
                        class="space-y-6"
                    >
                        <div class="space-y-2">
                            <InputLabel for="dumps" value="Dumps" />
                            <multiselect id="dumps" v-model="form.dumps" :options="dumps" :multiple="true" :close-on-select="false" :clear-on-select="false"
                                         :preserve-search="true" placeholder="Pick dumps">
                                <template #selection="{ values, search, isOpen }">
                                    <span class="multiselect__single"
                                          v-if="values.length"
                                          v-show="!isOpen">{{ values.length }} options selected</span>
                                </template>
                            </multiselect>
                            <InputError class="mt-2" :message="form.errors.dumps" />
                        </div>

                        <div class="space-y-2">
                            <InputLabel for="export-type" value="Export type" />
                            <multiselect id="export-type" v-model="form.export_type" :options="exportTypes" :searchable="false" :close-on-select="true" :show-labels="false"
                                         placeholder="Pick a value"></multiselect>
                            <InputError class="mt-2" :message="form.errors.export_type" />
                        </div>

                        <div>
                            <PrimaryButton :disabled="form.processing">Export</PrimaryButton>
                        </div>
                    </form>
                </div>
            </slot>


        </Modal>

        <PrimaryButton @click="toggleModal">
            Export Articles
        </PrimaryButton>
    </div>

</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
