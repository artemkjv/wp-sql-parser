<script setup>

import {ref} from "vue";
import Modal from "@/Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const showModal = ref(false)
const form = useForm({
    dump: null
})
const toggleModal = () => {
    showModal.value = !showModal.value
}

const dumpPlaceholder = ref('Select a dump file')

const handleFileChange = (e) => {
    form.dump = e.target.files[0]
    dumpPlaceholder.value = 'Selected: ' + e.target.files[0].name
}

const submit = () => {
    form.post(route('dumps.store'), {
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
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col items-center px-4 py-6 bg-white text-blue-500 rounded-lg shadow-lg tracking-wide uppercase border border-blue-500 cursor-pointer hover:bg-blue-500 hover:text-white">
                                    <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M16.88 11.37l-5.18-5.19A3.34 3.34 0 008.34 3H4.5A2.5 2.5 0 002 5.5v9A2.5 2.5 0 004.5 17h11a2.5 2.5 0 002.5-2.5v-4a3.33 3.33 0 00-.95-2.13zm-9.82-.1a1.34 1.34 0 11-.01 2.67 1.34 1.34 0 01.01-2.67zM15.5 10h-1.6l-3.82-3.82a2.33 2.33 0 00-1.65-.68H8v4a1.33 1.33 0 01-1.33 1.33h-4v5h4a1.33 1.33 0 011.33 1.33v2.67z"/></svg>
                                    <span class="mt-2 text-base leading-normal">{{ dumpPlaceholder }}</span>
                                    <input type="file" class="sr-only" @change="handleFileChange" />
                                </label>
                            </div>
                            <InputError class="mt-2" :message="form.errors.dump" />
                        </div>

                        <div>
                            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                        </div>
                    </form>
                </div>
            </slot>


        </Modal>

        <PrimaryButton @click="toggleModal">
            Add Dump
        </PrimaryButton>
    </div>

</template>

