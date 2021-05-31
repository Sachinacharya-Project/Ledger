let counter = 1;
// Add Product field
const addProductField = ()=>{
    counter++;
    $.post('data_purchases.php', {
        queryType: 'product_and_units'
    }, (data, status)=>{
        if(data && data.length != 0){
            let productNameOpt = ``;
            let productUnitOpt = ``;
            let unit_list = []
            data[0].forEach(contains => {
                if(!unit_list.includes(contains['unit'])){
                    productUnitOpt += `<option value='${contains['unit']}'>${contains['unit']}</option>`;
                    unit_list.push(contains['unit'])
                }
                productNameOpt += `<option value='${contains['name']}'>${contains['name']}</option>`;
            })
            const html = `
                    <div class="item item-${counter}">
                    <fieldset>
                        <legend>Product Name</legend>
                        <input type="text" list="productname" placeholder="Product Name" autocomplete="off" class="productname">
                        <datalist id="productname">
                            ${productNameOpt}
                        </datalist>
                    </fieldset>
                    <fieldset>
                        <legend>Product Unit</legend>
                        <input type="text" list="productunit" class="productunit" placeholder="Product Unit">
                        <datalist id="productunit">
                            ${productUnitOpt}
                        </datalist>
                    </fieldset>
                    <fieldset>
                        <legend>Quantity</legend>
                        <input type="text" class="quantity" autocomplete="off" placeholder="Quantity">
                    </fieldset>
                </div>
            `
            const addingProduct = document.querySelector('.addingProduct .contents')
            addingProduct.insertAdjacentHTML("afterbegin", html)
        }
    })
}
// Fetch and add Products and units in Adding product section for item-1
const setProductNameAtFirst = ()=>{
    $.post("/models/data_purchases.php", {
        queryType: 'product_and_units'
    }, (data, status)=>{
        const rootDiv = document.querySelector('.item-1')
        const prodname = rootDiv.querySelector(".datalist-productname")
        const unit = rootDiv.querySelector(".datalist-productunit")
        if(data && data.length != 0){
            let productNameOpt = ``;
            let productUnitOpt = ``;
            let unit_list = []
            data[0].forEach(contains => {
                if(!unit_list.includes(contains['unit'])){
                    productUnitOpt += `<option value='${contains['unit']}'>${contains['unit']}</option>`;
                    unit_list.push(contains['unit'])
                }
                productNameOpt += `<option value='${contains['name']}'>${contains['name']}</option>`;
            })
            prodname.innerHTML = productNameOpt
            unit.innerHTML = productUnitOpt
        }
    })
}
// Add products to database
const addProducts = ()=>{
    const addingProduct = document.querySelectorAll('.addingProduct .contents .item')   
    const datas = []
    addingProduct.forEach(divison => {
        const prodname = divison.querySelector(".productname")
        const unit = divison.querySelector('.productunit')
        const quantity = divison.querySelector('.quantity')
        if (prodname.value != '' && unit.value != '' && quantity.value != ''){
            datas.push([prodname.value, unit.value, quantity.value])
        }
        if(!divison.classList.contains("item-1")){
            divison.remove()
        }else{
            prodname.value = ''
            unit.value = ''
            quantity.value = ''
        }
    })
    if(datas.length != 0){
        $.post('/models/data_purchases.php', {
            queryType: 'adding_products',
            datas
        })
    }
}
// What to show and what not to show
const controlInterface = (classname)=>{
    const allMetaDiv = document.querySelectorAll(".metadiv")
    allMetaDiv.forEach(div => {
        if(div.classList.contains(classname)){
            div.classList.add('active')
        }else{
            div.classList.remove('active')
        }
    })
}
const options = document.getElementById('optionsTransactions')
options.addEventListener('change', ()=>{
    const theValue = options.value
    const legend = document.querySelector('legend')
    if(theValue === "addProducts"){
        legend.textContent = 'Adding Products'
        controlInterface('addingProduct')
        setProductNameAtFirst()
    }else if(theValue === 'showProducts'){
        legend.textContent = 'Showing Products Details'
        controlInterface('showingProducts')
        fetchListOfProducts()
    }
})
// Display products list
const fetchListOfProducts = ()=>{
    const root = document.querySelector('.showingProducts .contents')
    $.post("/models/data_purchases.php", {
        queryType: 'showing_prod',
    }, (data, status)=>{
        if(data && data.length != 0){
            data.forEach(dats => {
                let classColor = 'noColor';
                if(dats['status'] === 'Almost Out'){
                    classColor = 'orangeRed';
                }else if(dats['status'] == 'Out Of Stock'){
                    classColor = 'red'
                }
                root.innerHTML += `
                    <div class="items">
                        <p>
                            <strong>Product Name: </strong> <span>${dats['name']}</span>
                        </p>
                        <p>
                            <strong>Quantity InStock: </strong>${dats['quantity']}
                        </p>
                        <p>
                            <strong>Unit: </strong>${dats['unit']}
                        </p>
                        <p class='${classColor}'>
                            <strong>Status: </strong> <span>${dats['status']}</span>
                        </p>
                    </div>
                `;
            })
        }else{
            root.textContent = 'No Data Found!';
        }
    })
}
// Second Step for adding Purchase
const purchaseNext = ()=>{
    const basicDetails = document.querySelector('.addingPurchases .basic_details')
    const productsDetails = document.querySelector('.addingPurchases .productsDetails')
    if(confirm("Are you sure these details are correct? (Cannot be changed later on)")){
        basicDetails.style.display = 'none'
        productsDetails.style.display = 'flex'
        document.querySelectorAll('.hidden-purchase-btn').forEach(item => {
                item.style.display = 'block'
        })
        document.querySelector('.addingPurchases .notify').textContent = `If Product is new, no need to add unit(Pricing in in Nepali Currency)`
        /**
         * Getting Units and products name
         */
        $.post('/models/data_purchases.php', {
            queryType: 'product_and_units'
        }, (data, status)=>{
            let productsListHTML = ``
            const unitList = []
            let unitListHTML = ``
            if(data && data.length != 0){
                data[0].forEach(dats => {
                    productsListHTML += `<option value='${dats['name']}'></option>`;
                    if(!unitList.includes(dats['unit'])){
                        unitListHTML += `<option value='${dats['unit']}'></option>`
                        unitList.push(dats['unit'])
                    }
                })
                document.querySelector(".productsDetails .item-1 .ClassproductName").innerHTML = productsListHTML
                document.querySelector(".productsDetails .item-1 .ClassUnit").innerHTML = unitListHTML
            }
        })
    }
}
// Adding Field to Purchases
let productCounter = 1
const addPurchaseField = ()=>{
    productCounter++
    const rootDivision = document.querySelector('.productsDetails')
    counter++;
    $.post('data_purchases.php', {
        queryType: 'product_and_units'
    }, (data, status)=>{
        if(data && data.length != 0){
            let productNameOpt = ``;
            let productUnitOpt = ``;
            let unit_list = []
            data[0].forEach(contains => {
                if(!unit_list.includes(contains['unit'])){
                    productUnitOpt += `<option value='${contains['unit']}'>${contains['unit']}</option>`;
                    unit_list.push(contains['unit'])
                }
                productNameOpt += `<option value='${contains['name']}'>${contains['name']}</option>`;
            })
            const html = `
            <div class="item item-${productCounter}">
            <fieldset>
                <legend>Product Name</legend>
                <input type="text" placeholder="Product Name" list="ClassproductName">
                <datalist id="ClassproductName" class="ClassproductName">
                    ${productNameOpt}
                </datalist>
            </fieldset>
            <fieldset>
                <legend>Quantity</legend>
                <input type="text" class="quantity" placeholder="Quantity">
            </fieldset>
            <fieldset>
                <legend>Unit</legend>
                <input type="text" placeholder="Unit" class="unit" list="ClassUnit">
                <datalist id="ClassUnit" class="ClassUnit">
                    ${productUnitOpt}
                </datalist>
            </fieldset>
            <fieldset>
                <legend>Rate</legend>
                <input type="text" placeholder="Rate" class="rate">
            </fieldset>
            <p data-total="1000" class="total">
                <strong>Total: </strong><span>1000/-</span>
            </p>
        </div>
            `
            const addingProduct = document.querySelector('.addingPurchases .contents')
            addingProduct.insertAdjacentHTML("afterbegin", html)
        }
    })
}
// Ading Purchases to the databases
const addPurchases = ()=>{
    const rootDiv = document.querySelector(".addingPurchases")
    // Collecting Shopdetails
    const shop_root_div = rootDiv.querySelector(".basic_details")
    const shopkeepername = shop_root_div.querySelector('.shopname')
    const shopaddress = shop_root_div.querySelector(".cosaddress")
    const shophone = shop_root_div.querySelector('.cosphone')
    const regd = shop_root_div.querySelector('.registration')
    const data = {
        shopname: shopkeepername.value,
        address: shopaddress.value,
        phone: shophone.value,
        regd: regd.value
    }
    // Collecting Products List
    const product_root_div = rootDiv.querySelector('.prductList .productsDetails')
    const allproducts = product_root_div.querySelectorAll('.item')
    let apsoluteTotal = 0;
    let proddatalist = []
    allproducts.forEach(item => {
        const prodname = item.querySelector('.prodname')
        const quantity = item.querySelector('.quantity')
        const unit = item.querySelector('.unit')
        const rate = item.querySelector('.rate')
        const total = item.querySelector('.total').getAttribute(['data-total'])
        if(prodname.value != '' && quantity.value != '' && unit.value != '' && rate.value != ''){
            proddatalist.push([prodname.value, quantity.value, rate.value, unit.value, total])
            apsoluteTotal += total
        }
        if(!item.classList.contains('item-1')){
            item.remove()
        }else{
            prodname.value = ''
            quantity.value = ''
            unit.value = ''
            rate.value = ''
            item.querySelector('.total').setAttribute('data-total', 0)
        }
    })
    data.data = proddatalist
    data.total = apsoluteTotal
    $.post('/models/data_purchases.php', {
        queryType = 'add_to_purchase',
        data
    }, (data, status)=>{
        console.log(data);
    })
}