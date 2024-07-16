export default function CreateButton({
    onClick = "",
    className = "",
    disabled,
    children,
    ...props
}) {
    return (
        <button
            onClick={onClick}
            {...props}
            className={`btn btn-primary fw-bold fs-8 fs-lg-base ` + className}
            disabled={disabled}
        >
            <i className="ki-duotone ki-plus fs-2"></i>
            {children}
        </button>
    );
}
