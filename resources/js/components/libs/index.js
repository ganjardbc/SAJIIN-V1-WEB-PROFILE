import M from 'moment'

const changeSunday = (date) => {
    const day = M(date).format('dddd')
    if (day === "Minggu") {
        return ("Ahad, " + M(date).format('Do MMMM YYYY'))
    } else {
        return M(date).format('dddd, Do MMMM YYYY')
    }
},

export default changeSunday