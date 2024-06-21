import{o as v,e as w,w as c,h as l,f as a,u as x,r as b,d as S,i as f,j as _,k as $}from"./app-CKrSXwPE.js";import{_ as E}from"./number-qKCM2p7Q.js";import{_ as y}from"./Button.vue_vue_type_script_setup_true_lang-BXoxDvKt.js";import{_ as k}from"./TextInput.vue_vue_type_script_setup_true_lang-CQWfOa6n.js";const j={__name:"CreateCategoryModal",props:{show:{type:Boolean,default:()=>!1},type:{type:String,required:!0}},emits:["close","success"],setup(n,{emit:u}){const s=u;return(i,t)=>(v(),w(a(E),{show:n.show,title:"Create Category","wrapper-class":"lg:max-w-[500px]",onClose:t[2]||(t[2]=o=>s("close"))},{"body-footer":c(()=>[l(a(V),{"api-route":"REQUEST_CREATE_CATEGORY",type:n.type,onClose:t[0]||(t[0]=o=>s("close")),onSuccess:t[1]||(t[1]=o=>s("success"))},null,8,["type"])]),_:1},8,["show"]))}},R={class:"px-6 pt-6 pb-8 space-y-4"},T={class:"flex items-center justify-end gap-x-4 p-4"},V={__name:"CategoryForm",props:{model:{type:Object,default:()=>{}},apiRoute:{type:String,required:!0},type:{type:String,required:!0}},emits:["close","success"],setup(n,{emit:u}){const s=n,i=u,o=x().dispatch,e=b({name:null,type:s.type,errors:{},success:!1,...s.model}),C=async()=>{e.value.errors={};const{data:m,status:r}=await o(s.apiRoute,e.value);[200,201].includes(r)?(e.value.success=!0,g(),o("SHOW_NOTIF_ALERT",{message:"Changes saved."}),i("success")):(e.value.errors=m.errors,e.value.errors.name="")},g=()=>{e.value={name:null,errors:{},success:!1}};return(m,r)=>{var p;return v(),S("form",{novalidate:"",onSubmit:$(C,["prevent"])},[f("div",R,[l(a(k),{modelValue:e.value.name,"onUpdate:modelValue":r[0]||(r[0]=d=>e.value.name=d),label:"Name",errors:(p=e.value.errors)==null?void 0:p.name},null,8,["modelValue","errors"])]),f("div",T,[l(a(y),{variant:"blank",onClick:r[1]||(r[1]=d=>i("close"))},{default:c(()=>[_(" Cancel ")]),_:1}),l(a(y),{type:"submit"},{default:c(()=>[_(" Confirm ")]),_:1})])],32)}}};export{j as _,V as a};
