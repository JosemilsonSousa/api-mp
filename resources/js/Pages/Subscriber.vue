<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';

    const props = defineProps({
        subscriber: { type: Array },
        user: { type: String },
        plan: { type: String },
    });

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>

            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Assinante: {{ user }}
                </h2>
                <Link :href="route('dash.assinantes')" class="p-2 rounded-md bg-sky-500 hover:bg-sky-700 text-blue-50">
                    Voltar
                </Link>
            </div>

        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8"> 
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-5 text-gray-900 flex justify-between">
                        <div class="w-3xs bg-purple-50 shadow-sm p-5 rounded-md">
                            <span class="text-3xl">nº {{ subscriber.id }}</span>
                        </div>
                        <div class="w-3xs bg-purple-50 shadow-md p-5 rounded-md">
                            <span class="text-2xl">Plano: {{ plan }}</span>
                        </div>
                        <div class="w-3xs bg-purple-50 shadow-md p-5 rounded-md">
                            <span class="text-3xl">Status: {{ subscriber.status }}</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-5 text-gray-900">
                       <h2>Lista dos Assinantes</h2>
                        <table class="table-auto border border-gray-900 border-collapse" style="width: 100%;">  
                            <thead>    
                                <tr>            
                                    <th>Assinante</th>      
                                    <th>Plano</th>      
                                    <th>Status</th>    
                                </tr>  
                            </thead>  
                            <tbody>
                                <tr>
                                    <td class="p-3 border border-gray-900">Testando o som</td>
                                    <td class="p-3 border border-gray-900">Testando o som</td>
                                    <td class="p-3 border border-gray-900">Testando o som</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
