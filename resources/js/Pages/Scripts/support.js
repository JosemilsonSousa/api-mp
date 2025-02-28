import { router } from '@inertiajs/vue3';
import axios from 'axios';

const amount = function(){
    const elements = document.querySelectorAll('.amount');
    
    elements.forEach((el) => {
        let realBra = new Intl.NumberFormat('pt-BR', {style:'currency',currency:'BRA'});
        el.innerHTML = realBra.format(el.innerHTML);
        el.innerHTML = el.innerHTML.replace("BRA&nbsp;", "");
    });
}

const getAddress = function(a){
    var c = a.replace(/\D/g, '');
    var v = /^[0-9]{8}$/;
    if (c != "" && v.test(c)) return axios.get(`https://viacep.com.br/ws/${c}/json`).then(a => { return a.data });
}

const aHref   = (url) => { router.visit(route(url), {method: 'get'}); }
const getData = (url) => { return axios.get(url).then(a => { return a.data });}
const getPage = (url) => { window.location = route(url); }
const hermes  = function(a, f) {
    const h   = "'Content-Type': 'multipart/form-data'";
    return axios.post(a, f, { headers: {h} }).then(b => { return b.data }).catch(e => { return e.response });
}

const search = function(d){
    let url  = route(d.url);
    if(d.search != "") url = `${route(d.url)}?filter=${d.filter}&search=${d.search}`;
    router.visit(url, {preserveState: true})
}

const showBody = function(val){
    const height = document.querySelector('.content_body').offsetHeight + val;
    document.querySelector('.content_box').style.height = `${height}px`;
}

const showGrid = function(event){
    const elements = document.querySelectorAll('.item_link');
    elements.forEach((element) => { element.classList.remove('active'); });
    event.currentTarget.classList.add('active');
    
    var url = event.target.getAttribute('rel');
    
    const form = document.querySelectorAll('.form_content');
    form.forEach((element) => { element.classList.add('d-none'); });
    
    document.getElementById(url).classList.remove('d-none');
    showBody(40);
}

export { aHref, amount, getAddress, getData, getPage, hermes, search, showBody, showGrid }