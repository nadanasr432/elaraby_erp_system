(window.blocksyJsonP=window.blocksyJsonP||[]).push([[8],{29:function(e,t,n){"use strict";n.r(t),n.d(t,"mountMenuLevel",(function(){return r})),n.d(t,"handleUpdate",(function(){return d}));const s=()=>"rtl"===document.querySelector("html").dir,i=e=>e.classList.contains("animated-submenu")&&(!e.parentNode.classList.contains("menu")||-1===e.className.indexOf("ct-mega-menu")&&e.parentNode.classList.contains("menu"));const a=(e,t)=>{let{startPosition:n="end"}=t;const i=e.querySelector(".sub-menu"),a=(e=>{const t=function(e,t){for(var n=[];e.parentNode;)e.parentNode&&e.parentNode.matches&&e.parentNode.matches(t)&&n.push(e.parentNode),e=e.parentNode;return n[n.length-1]}(e,"li.menu-item");return t&&t.querySelector(".sub-menu .sub-menu .sub-menu")?t.getBoundingClientRect().left>innerWidth/2?"left":"right":s()?"left":"right"})(i),{left:c,width:o,right:r}=i.getBoundingClientRect();let l=a,d=e.getBoundingClientRect();if("left"===a){("end"===n?d.left:d.right)-o<0&&(l="right")}if("right"===a){("end"===n?d.right:d.left)+o>innerWidth&&(l="left")}e.dataset.submenu=l,e.addEventListener("click",()=>{})},c=e=>{const t=e.target.closest("li");t.classList.add("ct-active");let n=[...t.children].find(e=>e.matches(".ct-toggle-dropdown-desktop-ghost"));n.setAttribute("aria-expanded","true"),n.setAttribute("aria-label",ct_localizations.collapse_submenu),l({target:t})},o=e=>{const t=e.target.closest("li");t.classList.remove("ct-active");let n=[...t.children].find(e=>e.matches(".ct-toggle-dropdown-desktop-ghost"));n.setAttribute("aria-expanded","false"),n.setAttribute("aria-label",ct_localizations.expand_submenu),setTimeout(()=>{[...t.querySelectorAll("[data-submenu]")].map(e=>{e.removeAttribute("data-submenu")}),[...t.querySelectorAll(".ct-active")].map(e=>{e.classList.remove("ct-active")})},200)},r=function(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};[...e.children].filter(e=>e.matches(".menu-item-has-children, .page_item_has_children")).map(e=>{if(e.classList.contains("ct-mega-menu-custom-width")){const t=e.querySelector(".sub-menu"),n=e.getBoundingClientRect(),s=t.getBoundingClientRect();n.left+n.width/2+s.width/2>innerWidth&&(e.dataset.submenu="left"),n.left+n.width/2-s.width/2<0&&(e.dataset.submenu="right")}i(e)&&a(e,t);let n=[...e.children].find(e=>e.matches(".ct-toggle-dropdown-desktop-ghost"));if(n&&!n.hasEventListener){n.hasEventListener=!0;let e=n.matches('[data-interaction*="click"] *');if(n.addEventListener("keyup",e=>{13===e.keyCode&&(e.target.closest("li").classList.contains("ct-active")?o(e):(c(e),e.target.closest("li").addEventListener("focusout",t=>{e.target.closest("li").contains(t.relatedTarget)||o(e)})))}),e){(n.matches('[data-interaction*="item"] *')?n.previousElementSibling:n.previousElementSibling.querySelector(".ct-toggle-dropdown-desktop")).addEventListener("click",e=>{e.preventDefault(),e.target.closest("li").classList.contains("ct-active")?o(e):(c(e),e.target.closest("li").addEventListener("focusout",t=>{e.target.closest("li").contains(t.relatedTarget)||o(e)}))})}else n.closest("li").addEventListener("mouseenter",e=>{c({target:n}),e.target.closest("li").addEventListener("focusout",t=>{e.target.closest("li").contains(t.relatedTarget)||o(e)}),e.target.closest("li").addEventListener("mouseleave",()=>{o({target:n})},{once:!0})})}})},l=e=>{let{target:t}=e;if(t.matches(".menu-item-has-children, .page_item_has_children")||(t=t.closest(".menu-item-has-children, .page_item_has_children")),t.parentNode.classList.contains("menu")&&t.className.indexOf("ct-mega-menu")>-1&&-1===t.className.indexOf("ct-mega-menu-custom-width")&&window.wp&&wp&&wp.customize&&wp.customize("active_theme")){t.querySelector(".sub-menu").style.left=Math.round(t.closest('[class*="ct-container"]').firstElementChild.getBoundingClientRect().x)-Math.round(t.closest("nav").getBoundingClientRect().x)+"px"}if(!i(t))return;const n=t.querySelector(".sub-menu");r(n),n.closest('[data-interaction="hover"]')&&(n._timeout_id&&clearTimeout(n._timeout_id),n.parentNode.addEventListener("mouseleave",()=>{n._timeout_id=setTimeout(()=>{n._timeout_id=null,[...n.children].filter(e=>i(e)).map(e=>e.removeAttribute("data-submenu"))},200)},{once:!0}))},d=e=>{e.parentNode||(e=document.querySelector(`[class="${e.className}"]`)),e&&(e.querySelector(".menu-item-has-children")||e.querySelector(".page_item_has_children"))&&e.closest('[data-interaction="hover"]')&&(e.removeEventListener("mouseenter",l),e.addEventListener("mouseenter",l))}}}]);