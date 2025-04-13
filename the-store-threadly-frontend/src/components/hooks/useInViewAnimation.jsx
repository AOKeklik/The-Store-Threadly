import { useRef } from "react"
import { useInView } from "framer-motion"

const useInViewAnimation = ({ direction = "up", once = true } = {}) => {
    const ref = useRef(null)
    const isInView = useInView(ref, { once })

    const getTransform = () => {
        switch (direction) {
            case "up":
                return "translateY(60px)"
            case "down":
                return "translateY(-60px)"
            case "left":
                return "translateX(-60px)"
            case "right":
                return "translateX(60px)"
            default:
                return "translateY(60px)"
        }
    };

    const style = {
        transition: "all .7s cubic-bezier(.17,.55,.55,1) .3s",
        transform: isInView ? "translate(0,0)" : getTransform(),
        opacity: isInView ? 1 : 0,
    }

    return { ref, style }
}

export default useInViewAnimation