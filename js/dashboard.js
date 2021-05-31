const optionSelections = document.getElementById("optionsTransactions")
optionSelections.addEventListener('change', ()=>{
    const value = optionSelections.value
    console.log(value);
})

const NumberParse = ()=>{
    const DisplayingTextBoxes = document.querySelectorAll(".boxes")
    DisplayingTextBoxes.forEach(box => {
        const spanWithIn = box.querySelector("span")
        const dataValue = spanWithIn.textContent
        spanWithIn.setAttribute("data-value", dataValue)
        spanWithIn.textContent = `${parseInt(dataValue).toLocaleString()}/-`
    })
}