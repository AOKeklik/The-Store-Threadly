import { useRef } from "react";
import { useInView, motion } from "framer-motion";

export default function AnimateInView ({
    children,
    direction = "up",
    once = true,
    delay = 0.3,
    duration = 0.7,
    ...props
}) {
    const ref = useRef(null);
    const isInView = useInView(ref, { once });

    const getTransform = () => {
        switch (direction) {
        case "up":
            return "translateY(60px)";
        case "down":
            return "translateY(-60px)";
        case "left":
            return "translateX(-60px)";
        case "right":
            return "translateX(60px)";
        default:
            return "translateY(60px)";
        }
    }

    const style = {
            transition: `transform ${duration}s cubic-bezier(.17,.55,.55,1) ${delay}s, opacity ${duration}s ease ${delay}s`,
            transform: isInView ? "translate(0,0)" : getTransform(),
            opacity: isInView ? 1 : 0,
            willChange: "transform, opacity",
            ...props.style,
    }

    return (
        <motion.div ref={ref} style={style} {...props}>
            {children}
        </motion.div>
    )
}