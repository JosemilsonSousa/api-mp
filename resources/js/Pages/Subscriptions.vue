<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';

    const props = defineProps({
        plans: { type: Array },
    });

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>

            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Planos de Assinaturas
                </h2>
                <a :href="route('dash.plano.criar')" class="p-2 rounded-md bg-sky-500 hover:bg-sky-700 text-blue-50">
                    Novo Plano
                </a>
            </div>

        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                       <h2>Lista dos Planos de Assinaturas</h2>
                        <table class="table-auto border border-gray-900 border-collapse" style="width: 100%;">  
                            <thead>    
                                <tr>      
                                    <th>Song</th>      
                                    <th>Artist</th>      
                                    <th>Year</th>    
                                </tr>  
                            </thead>  
                            <tbody>
                                <tr v-for="plan in props.plans">
                                    <td class="p-3 border border-gray-900">{{ plan.reason }}</td>
                                    <td class="p-3 border border-gray-900">{{ plan.transaction_amount }}</td>
                                    <td class="p-3 border border-gray-900">{{ plan.status }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
