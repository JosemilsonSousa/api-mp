<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import NavLink from '@/Components/NavLink.vue';

    const props = defineProps({
        subscribers: { type: Array },
    });

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>

            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Assinaturas
                </h2>
                <a :href="route('dash.assinar.plano')" class="p-2 rounded-md bg-sky-500 hover:bg-sky-700 text-blue-50">
                    Novo Assinantes
                </a>
            </div>

        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                       <h2>Lista dos Assinantes</h2>
                        <table class="table-auto border border-gray-900 border-collapse" style="width: 100%;">  
                            <thead>    
                                <tr>      
                                    <th></th>      
                                    <th>Assinante</th>      
                                    <th>Plano</th>      
                                    <th>Status</th>    
                                </tr>  
                            </thead>  
                            <tbody>
                                <tr v-for="subscriber in props.subscribers">
                                    <td class="p-3 border border-gray-900">
                                        <Link :href="route('dash.assinatura.plano',subscriber.id)"
                                            class="p-2 rounded-md bg-green-700 hover:bg-green-600 text-green-50"
                                        >Ver</Link>
                                    </td>
                                    <td class="p-3 border border-gray-900">{{ subscriber.user.name }}</td>
                                    <td class="p-3 border border-gray-900">{{ subscriber.subscription.reason }}</td>
                                    <td class="p-3 border border-gray-900">{{ subscriber.status }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
