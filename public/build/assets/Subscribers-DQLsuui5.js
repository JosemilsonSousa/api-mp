import{_ as b}from"./AuthenticatedLayout-C1XXfMfO.js";import{f as r,o,a,u as i,m,w as n,b as s,F as u,B as _,P as c,e as g,t as d}from"./app-Bxl77j85.js";import"./ApplicationLogo-D9kxGlJ6.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const f={class:"flex items-center justify-between"},y=["href"],x={class:"py-12"},v={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},w={class:"overflow-hidden bg-white shadow-sm sm:rounded-lg"},A={class:"p-6 text-gray-900"},k={class:"table-auto border border-gray-900 border-collapse",style:{width:"100%"}},B={class:"p-3 border border-gray-900"},N={class:"p-3 border border-gray-900"},V={class:"p-3 border border-gray-900"},P={class:"p-3 border border-gray-900"},j={__name:"Subscribers",props:{subscribers:{type:Array}},setup(h){const p=h;return(l,t)=>(o(),r(u,null,[a(i(m),{title:"Dashboard"}),a(b,null,{header:n(()=>[s("div",f,[t[0]||(t[0]=s("h2",{class:"text-xl font-semibold leading-tight text-gray-800"}," Assinaturas ",-1)),s("a",{href:l.route("dash.assinar.plano"),class:"p-2 rounded-md bg-sky-500 hover:bg-sky-700 text-blue-50"}," Novo Assinantes ",8,y)])]),default:n(()=>[s("div",x,[s("div",v,[s("div",w,[s("div",A,[t[3]||(t[3]=s("h2",null,"Lista dos Assinantes",-1)),s("table",k,[t[2]||(t[2]=s("thead",null,[s("tr",null,[s("th"),s("th",null,"Assinante"),s("th",null,"Plano"),s("th",null,"Status")])],-1)),s("tbody",null,[(o(!0),r(u,null,_(p.subscribers,e=>(o(),r("tr",null,[s("td",B,[a(i(c),{href:l.route("dash.assinatura.plano",e.id),class:"p-2 rounded-md bg-green-700 hover:bg-green-600 text-green-50"},{default:n(()=>t[1]||(t[1]=[g("Ver")])),_:2},1032,["href"])]),s("td",N,d(e.user.name),1),s("td",V,d(e.subscription.reason),1),s("td",P,d(e.status),1)]))),256))])])])])])])]),_:1})],64))}};export{j as default};
