const queredURL = document.location.href.toString()
// Handling Login and all
const loginContainer = document.querySelector(".login")
const signUpContainer = document.querySelector(".signup")

loginContainer.classList.add('active')
signUpContainer.classList.remove('active')
document.title = 'Account | Login'
if(queredURL.includes('/?signup')){
    loginContainer.classList.remove('active')
    signUpContainer.classList.add('active')
    document.title = 'Account | SignUp'
}else if(queredURL.includes('/?logout')){
    document.title = 'Account | Logout'
    $.post('/models/logout.php',{
        confirmation: "yes"
    }, ()=>{
        document.location.href = '/'
    })
}
const togglePassword = (inputBox, handler)=>{
    console.log(handler);
    const inputArea = document.getElementById(inputBox)
    if(handler.classList.contains('fa-eye')){
        inputArea.type = 'text'
        handler.classList.remove('fa-eye')
        handler.classList.add('fa-eye-slash')
    }else{
        inputArea.type = 'password'
        handler.classList.add('fa-eye')
        handler.classList.remove('fa-eye-slash')
    }
}

const nextStep = ()=>{
    if(confirm("Make Sure you entered correct details in this step\nLater can be changed")){
        const firststep = document.querySelector(".firststep")
        const secondstep = document.querySelector('.secondstep')
        firststep.classList.remove('active')
        secondstep.classList.add("active")
    }
}

const accountHandle = (service)=>{
    let root_div = document.querySelector(`.${service}`)
    const nullvalue = document.querySelector('.nullvalue')
    const username = root_div.querySelector(".username")
    const password = root_div.querySelector('.password')
    const email = root_div.querySelector('.email') || nullvalue
    const fullname = root_div.querySelector('.name') || nullvalue
    if(service === 'signup'){
        root_div = document.querySelector('.secondstep')
    }
    const shopname = root_div.querySelector(".shopname") || nullvalue
    const regd = root_div.querySelector(".regd") || nullvalue
    const address = root_div.querySelector('.address') || nullvalue
    const phone = root_div.querySelector(".phone") || nullvalue
    data = {
        username: username.value,
        password: password.value,
        email: email.value,
        fullname: fullname.value,
        shopname: shopname.value,
        regd: regd.value,
        address: address.value,
        phone: phone.value
    }
    $.post("/models/account.php", {
        service,
        data
    }, (data, status)=>{
        console.log(data);
        if(data == 'success'){
            document.location.href = '/models/dashboard.php'
        }else{
            document.location.reload()
        }
    })
}