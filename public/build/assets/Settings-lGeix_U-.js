import{u as g,r as S,o as x,e as N,w as c,i as o,h as l,f as a,j as b,k as T,t as E,c as k,l as O,d as U,F as j,g as F}from"./app-CKrSXwPE.js";import{_ as P,C as $}from"./Button.vue_vue_type_script_setup_true_lang-BXoxDvKt.js";import{_ as A}from"./Heading.vue_vue_type_script_setup_true_lang-CK63fm-h.js";import{_ as d}from"./TextInput.vue_vue_type_script_setup_true_lang-CQWfOa6n.js";/* empty css            */const R={class:"mb-3 flex items-center justify-between gap-x-2"},z={class:"w-full !mt-5"},B=["textContent"],D={__name:"ChangePassword",setup(V){const p=g().dispatch,e=S({current_password:null,new_password:null,confirm_password:null,errors:{},success:""}),s=()=>{e.value={current_password:null,new_password:null,confirm_password:null,errors:{},success:""}},w=async()=>{if(e.value.errors={},e.value.new_password!==e.value.confirm_password)return e.value.errors.message="Passwords does not match.",!1;const{status:i,data:t}=await p("UPDATE_PASSWORD",e.value);i===200?(e.value.success=!0,s(),p("SHOW_NOTIF_ALERT",{message:"Changes saved."})):(e.value.errors=t.errors||t,e.value.errors.name="")};return(i,t)=>(x(),N(a($),{class:"md:max-w-[400px] flex-1 h-max"},{default:c(()=>{var _,f,v,r;return[o("div",R,[l(a(A),{as:"h3"},{default:c(()=>[b("Change Password")]),_:1})]),o("form",{novalidate:"",class:"space-y-4",onSubmit:T(w,["prevent"])},[l(a(d),{modelValue:e.value.current_password,"onUpdate:modelValue":t[0]||(t[0]=u=>e.value.current_password=u),name:"current_password",type:"password",label:"Current Password*",errors:(_=e.value.errors)==null?void 0:_.current_password},null,8,["modelValue","errors"]),l(a(d),{modelValue:e.value.new_password,"onUpdate:modelValue":t[1]||(t[1]=u=>e.value.new_password=u),name:"new_password",type:"password",label:"New Password*",errors:(f=e.value.errors)==null?void 0:f.new_password},null,8,["modelValue","errors"]),l(a(d),{modelValue:e.value.confirm_password,"onUpdate:modelValue":t[2]||(t[2]=u=>e.value.confirm_password=u),type:"password",name:"confirm_password",label:"Confirm Password*",errors:(v=e.value.errors)==null?void 0:v.confirm_password},null,8,["modelValue","errors"]),o("div",z,[o("small",{class:"text-red-500 block mb-2",textContent:E((r=e.value.errors)==null?void 0:r.message)},null,8,B),l(a(P),{type:"submit","btn-type":"primary","btn-size":"md","text-size":"lg",class:"w-full justify-center"},{default:c(()=>[b(" Update ")]),_:1})])],32)]}),_:1}))}},H={class:"mb-3 flex items-center justify-between gap-x-2"},I={class:"w-full !mt-5"},L=["textContent"],W={__name:"AccountSettings",props:{model:{type:Object,required:!0}},setup(V){var i,t,_,f;const n=V,e=g().dispatch,s=S({first_name:((i=n.model)==null?void 0:i.first_name)??null,last_name:((t=n.model)==null?void 0:t.last_name)??null,email:((_=n.model)==null?void 0:_.email)??null,username:((f=n.model)==null?void 0:f.username)??null,errors:{},success:""}),w=async()=>{const{status:v,data:r}=await e("UPDATE_ACCOUNT_SETTINGS",s.value);v===200?(s.value.success=!0,e("SHOW_NOTIF_ALERT",{message:"Changes saved."})):(s.value.errors=r.errors,s.value.errors.name="")};return(v,r)=>(x(),N(a($),{class:"md:max-w-[500px] flex-1"},{default:c(()=>{var u,y,C,h;return[o("div",H,[l(a(A),{as:"h3"},{default:c(()=>[b("Account Settings")]),_:1})]),o("form",{novalidate:"",class:"space-y-4",onSubmit:T(w,["prevent"])},[l(a(d),{modelValue:s.value.first_name,"onUpdate:modelValue":r[0]||(r[0]=m=>s.value.first_name=m),name:"first_name",label:"First Name*",errors:(u=s.value.errors)==null?void 0:u.first_name},null,8,["modelValue","errors"]),l(a(d),{modelValue:s.value.last_name,"onUpdate:modelValue":r[1]||(r[1]=m=>s.value.last_name=m),name:"last_name",label:"Last Name*",errors:(y=s.value.errors)==null?void 0:y.last_name},null,8,["modelValue","errors"]),l(a(d),{modelValue:s.value.email,"onUpdate:modelValue":r[2]||(r[2]=m=>s.value.email=m),name:"email",label:"Email*",errors:(C=s.value.errors)==null?void 0:C.email},null,8,["modelValue","errors"]),l(a(d),{modelValue:s.value.username,"onUpdate:modelValue":r[3]||(r[3]=m=>s.value.username=m),name:"username",label:"Username*",errors:(h=s.value.errors)==null?void 0:h.username},null,8,["modelValue","errors"]),o("div",I,[o("small",{class:"text-red-500 block mb-2",textContent:E(s.value.errors.message)},null,8,L),l(a(P),{type:"submit","btn-type":"primary","btn-size":"md","text-size":"lg",class:"w-full justify-center",disabled:!s.value.first_name||!s.value.last_name||!s.value.email||!s.value.username},{default:c(()=>[b(" Update ")]),_:1},8,["disabled"])])],32)]}),_:1}))}},M={class:"container md:py-2 lg:py-5 md:px-2 lg:px-8"},q={class:"flex flex-col md:flex-row gap-x-10 gap-y-5 w-full"},Y={__name:"Settings",setup(V){const n=g(),p=n.dispatch,e=k(()=>n.state.auth.user);O(()=>s());const s=()=>p("FETCH_CURRENT_USER");return(w,i)=>(x(),U("div",M,[o("div",q,[e.value?(x(),U(j,{key:0},[l(a(W),{model:e.value},null,8,["model"]),l(a(D),{model:e.value},null,8,["model"])],64)):F("",!0)])]))}};export{Y as default};
