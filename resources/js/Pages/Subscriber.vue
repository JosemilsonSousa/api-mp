<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import { onMounted } from 'vue';
    import { loadMercadoPago } from '@mercadopago/sdk-js';

    const props = defineProps({
        subscriber: { type: Array },
        invoces:    { type: Array },
        user:       { type: String },
        plan:       { type: String },
        publicKey:  { type: String },
    });

    console.log(props.user.email);
    const openModal = ()=>{
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
    }
    const closeModal = ()=>{
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }
    
    // Função para renderizar o Wallet Brick
    const renderWalletBrick = async () => {
        // Carrega a SDK do MercadoPago
        await loadMercadoPago();

        // Inicializa o MercadoPago com sua chave pública
        const mp = new window.MercadoPago(props.publicKey, {
            locale: 'pt-BR', // Idioma (opcional)
        });

        // Obtém o builder de Bricks
        const bricksBuilder = mp.bricks();

        // Renderiza o Wallet Brick
        bricksBuilder.create('cardPayment', 'cardPayment_container', {
            initialization: {
                amount: 100.0,
                payer: {   
                    identification: {
                        "type": "CPF",
                        "number": props.user.doc,
                    },
                    email: props.user.email,
                },
            },
            callbacks: {
                onReady: () => {
                    console.log('Wallet Brick está pronto!');
                },
                onError: (error) => {
                    console.error('Erro no Wallet Brick:', error);
                },
            },
        });
    };

    // Quando o componente é montado, renderiza o Brick
    onMounted(() => {
        renderWalletBrick();
    });

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>

            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Assinante: {{ user.name }}
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
                        <div class="w-3xs bg-green-50 shadow-sm p-5 rounded-md">
                            <span class="text-3xl">nº {{ subscriber.id }}</span>
                        </div>
                        <div class="w-3xs bg-green-50 shadow-md p-5 rounded-md">
                            <span class="text-2xl">Plano: {{ plan }}</span>
                        </div>
                        <div class="w-3xs bg-green-50 shadow-md p-5 rounded-md">
                            <span class="text-3xl">Status: {{ subscriber.status }}</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-5 text-gray-900">
                       <h2 class="p-2 text-2xl font-semibold">Lista dos Assinantes</h2>
                        <table class="table-auto border border-gray-900 border-collapse" style="width: 100%;">  
                            <thead>    
                                <tr>            
                                    <th>Id</th>      
                                    <th>Plano</th>      
                                    <th>Status</th>    
                                    <th></th>    
                                </tr>  
                            </thead>  
                            <tbody>
                                <tr v-for="invoce in props.invoces">
                                    <td class="p-3 border border-gray-900 text-center">{{ invoce.id }}</td>
                                    <td class="p-3 border border-gray-900">Testando o som</td>
                                    <td class="p-3 border border-gray-900 text-center">{{ invoce.status }}</td>
                                    <td class="p-3 border border-gray-900 text-center">
                                        <button id="openModal" @click="openModal">Pagar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" @click="closeModal">&times;</span>
                <div id="cardPayment_container"></div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>
    /* Estilo do fundo escuro quando a modal está aberta */
    .modal {
        display: none; /* Escondido por padrão */
        position: fixed; /* Fica fixo na tela */
        z-index: 1; /* Fica por cima de outros elementos */
        left: 0;
        top: 0;
        width: 100%; /* Largura total */
        height: 100%; /* Altura total */
        overflow: auto; /* Habilita scroll se necessário */
        background-color: rgb(0, 0, 0); /* Cor de fundo */
        background-color: rgba(0, 0, 0, 0.5); /* Fundo escuro com transparência */
    }

    /* Estilo do conteúdo da modal */
    .modal-content {
        background-color: #fefefe;
        margin: 2% auto; /* Centraliza a modal na tela */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Largura do conteúdo */
        max-width: 600px; /* Largura máxima */
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        position: relative;
    }
    .modal-content span{
        position: absolute;
        right: 10px;
        top: -5px;
    }
    /* Estilo do botão de fechar */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>