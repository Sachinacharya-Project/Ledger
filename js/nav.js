const setnav = (active)=>{
    const html = `
        <nav>
        <h1>
            Ledger
        </h1>
        <li class="home">
            <a href="/">Home (Dashboard)</a>
        </li>
        <li class="transactions">
            <a href="/models/transactions.php">Transactions</a>
        </li>
        <li class="customers">
            <a href="/models/customers.php">Customers</a>
        </li>
        <li class="purchases">
            <a href="/models/purchase.php">Purchases</a>
        </li>
        <li class="sales">
            <a href="/models/sales.php">Sales</a>
        </li>
        <li class='settings'>
            <a href='/?settings'>
                <i class='fas fa-cog'></i>
            </a>
        </li>
    </nav>
    `;
    document.body.insertAdjacentHTML("afterbegin", html)
    document.querySelector(`.${active}`).classList.add('active')
    displayUserName()
}

const displayUserName = ()=>{
    $.post('/models/basicInfo.php', {
        asking: 'loggedIname'
    }, (data, status)=>{
        const textDom = document.querySelector(".signedInUser p")
        textDom.innerHTML = `Signed In as ${data}`
    })
}