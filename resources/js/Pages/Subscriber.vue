<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import { ref, onMounted } from 'vue';
    import { loadMercadoPago, bricksBuilder } from '@mercadopago/sdk-js';
    import { hermes, getData } from './Scripts/support.js';

    const props = defineProps({
        subscriber: { type: Array },
        invoces:    { type: Array },
        user:       { type: String },
        plan:       { type: String },
        publicKey:  { type: String },
    });

    const invoce = ref(null);

    const sendPix = async () => {
        // console.log(invoce.value);
        var back  = await hermes(route('dash.invoce.pay.pix', invoce.value), '');
    }

    const openModal = (code)=>{
        invoce.value = code
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
        // renderWalletBrick();
    }

    const closeModal = ()=>{
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }

    // Função para renderizar o Wallet Brick
    const renderWalletBrick = async () => {
        // Carrega a SDK do MercadoPago
        await loadMercadoPago();
        const mp = new window.MercadoPago(props.publicKey);// Inicializa o MercadoPago com sua chave pública
        const bricksBuilder = mp.bricks();// Obtém o builder de Bricks

        // Renderiza o Wallet Brick
        bricksBuilder.create('cardPayment', 'cardPayment_container', {
            initialization: {
                amount: 100.0,
                payer: {   
                    identification: {"type": "CPF", "number": props.user.doc,},
                    email: props.user.email,
                },
            },
            customization: {
                paymentMethods: {
                    // ticket: "all",
                    bankTransfer: "all",
                    // creditCard: "all",
                },
            },
            callbacks: {
                onReady: () => {
                    console.log('Wallet Brick está pronto!');
                },

                onSubmit: ({ selectedPaymentMethod, formData }) => {
                    // callback chamado ao clicar no botão de submissão dos dados
                    return new Promise((resolve, reject) => {
                        fetch("/process_payment", {
                            method: "POST",
                            headers: { "Content-Type": "application/json",},
                            body: JSON.stringify(formData),
                        })
                        .then((response) => response.json())
                        .then((response) => {
                            // receber o resultado do pagamento
                            resolve();
                        })
                        .catch((error) => {
                            // lidar com a resposta de erro ao tentar criar o pagamento
                            reject();
                        });
                    });
                },
                onError: (error) => {
                    console.error('Erro no Wallet Brick:', error);
                },
            },
        });
    };


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
                                        <button id="openModal" @click="openModal(invoce.id)"
                                            class="p-2 rounded-md bg-green-700 hover:bg-green-600 text-green-50" 
                                        >Pagar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div id="myModal" class="modal">
            <div class="modal-content rounded-md ">
                
                <div class="header p-2 flex justify-between items-center rounded-t-md bg-cyan-500">
                    <h1>Tela de Pagamento</h1>
                    <span class="close" @click="closeModal">X</span>
                </div>

                <div class="body p-4">
                    <div class="choose_pay flex justify-between">
                        <div class="w-3xs bg-green-50 shadow-sm p-5 rounded-md">
                            <button @click="sendPix">Cartão</button>
                        </div>
                        <div class="w-3xs bg-green-50 shadow-sm p-5 rounded-md">
                            Pix
                        </div>
                        <div class="w-3xs bg-green-50 shadow-sm p-5 rounded-md">
                            Boleto
                        </div>
                    </div>

                    <div id="pixPayment_container"></div>
                    <div id="cardPayment_container"></div>
                    <div id="bolPayment_container"></div>
                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>
    .modal {
        position: fixed;
        z-index: 100;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        transition: opacity 0.3s ease;
    }

    .modal-content {
        width: 500px;
        margin: auto;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
        transition: all 0.3s ease;
    }

    .close {
        color: #fff;
        float: right;
        font-size: 1em;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>