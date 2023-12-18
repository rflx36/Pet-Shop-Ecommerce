

let bg = document.getElementById('dark-bg');
let p_del_info = document.getElementById('product-delete-info');
let p_del_cont = document.getElementById('product-delete-cont');
let p_del_img_id = document.getElementById('product-delete-img-id');


let p_act_button = document.getElementById('product-action-cont-button-id');

let p_upd_cont = document.getElementById('product-update-cont');


function AddProduct() {
    
    bg.style.opacity = "0.25";
    bg.style.pointerEvents = "all";

    p_upd_cont.style.display = "block";
    
}


function ProductRequestUpdate(p_id) {
    
    p_act_button.value = p_id;
    p_act_button.click();

}
function ProductUpdate(id){
    
    document.getElementById('product-update-button-id').value = id;
    bg.style.opacity = "0.25";
    bg.style.pointerEvents = "all";

    p_upd_cont.style.display = "block";
}

function ProductDelete(item_img, item_name,item_id) {
    bg.style.opacity = "0.25";
    bg.style.pointerEvents = "all";

    p_del_img_id.style.backgroundImage = "url(CSS/Resources/ProductImages/" + item_img + ")";
    console.log("url(img/" + item_img + ")");
    p_del_info.innerHTML = " Are you sure you want to delete " + item_name + " ?";
    p_del_cont.style.display = "block";
    let temp_trigger_delete = document.getElementById('confirm-true');

    temp_trigger_delete.value = item_id
   // temp_trigger_delete.click();
}



function CloseProduct() {
    bg.style.opacity = "0";
    bg.style.pointerEvents = "none";


    
    p_del_cont.style.display = "none";
    p_upd_cont.style.display = "none";
}

function SetImage() {
   
    img_get.click();
    
}


let img_get = document.getElementById('product-image-input-id');
let img_p = document.getElementById('product-image-name-id');

img_get.addEventListener('change', ()=>{
    let img_bg = document.getElementById('product-image-button-id');
    if (img_get.value != "") {
        const file = img_get.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function () {
            localStorage.setItem("image", reader.result);
            // document.getElementById("product-image-button-id").setAttribute("src", localStorage.getItem("image"))
            img_bg.style.backgroundImage = "url(" + localStorage.getItem("image") + ")";
            img_p.textContent = "Change Image";
           localStorage.removeItem("image");
        };

    }
});


let p_info_id = document.getElementById('product-info-id');
let p_name_id = document.getElementById('product-name-id');

function SetUpdateInfoFocus(){
  
    p_info_id.style.height = p_info_id.scrollHeight + 'px' ;
}

function SetUpdateInfoBlur(){
    
    p_info_id.style.height = '24px';
    
}


function SetUpdateNameFocus(){
  
    p_name_id.style.height = p_name_id.scrollHeight + 'px';
}

function SetUpdateNameBlur(){
    
    
    p_name_id.style.height = '24px';
}

function RemoveDetailCont(c_id){
    
    let p_container = document.getElementById('product-input-detail-id');
    let cont = document.getElementById("product-detail-cont-id-"+c_id);

    cont.style.animationName = "detailExit";
    setTimeout(()=>{
         p_container.removeChild(cont);
    },300);
   

}
function AddDetailCont(){
    let totaltypes = document.getElementsByClassName('product-detail-cont');
    let p_container = document.getElementById('product-input-detail-id');
    let cont_id;
    let product_add = document.getElementById('product-add-id');

    for (let i = 0; i <= totaltypes.length ; i++){
        if (document.getElementById('product-detail-cont-id-'+i) == null  ){
            cont_id = i;
            break;
        }
    }
     var containerDiv = document.createElement("div");
     containerDiv.classList.add("product-detail-cont");
     var uniqueId = "product-detail-cont-id-" + cont_id;
     containerDiv.id = uniqueId;

     var inputDetailType = document.createElement("input");
     inputDetailType.setAttribute("type", "text");
     inputDetailType.setAttribute("placeholder", "Detail Type");
     
     inputDetailType.setAttribute("class", "product-detail-input");
     inputDetailType.id = "p-detail-" + cont_id + "-0";

     var inputTypeInfo = document.createElement("input");
     inputTypeInfo.setAttribute("type", "text");
     inputTypeInfo.setAttribute("placeholder", "Type Info");
     inputTypeInfo.setAttribute("class", "product-detail-input");
     
     inputTypeInfo.id = "p-detail-" + cont_id + "-1";

     var removeButton = document.createElement("div");
     removeButton.classList.add("product-detail-cont-remove");
     removeButton.setAttribute("onclick","RemoveDetailCont("+cont_id+");");
     p_container.removeChild(product_add);
     containerDiv.appendChild(inputDetailType);
     containerDiv.appendChild(inputTypeInfo);
     containerDiv.appendChild(removeButton);
     p_container.appendChild(containerDiv);
     p_container.appendChild(product_add);
     containerDiv.style.animationName = "detailEntry";  

}

function SetUpdateProduct(){
    p_detail_inputs = document.getElementsByClassName("product-detail-input");
    var data = "";

    for (let i = 0 ; i < p_detail_inputs.length ; i++){
        if (p_detail_inputs[i].value != ""){

        
            data += p_detail_inputs[i].value + "<!/r>";
        }
        else{
            data += " <!/r>";
        }
    }
    document.getElementById('product-details-id').value = data;
}











