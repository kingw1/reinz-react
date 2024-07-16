export default function DeleteButton({
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
            className={
                `btn btn-icon btn-bg-light btn-active-color-primary btn-sm btn-active-light-primary w-30px h-30px ` +
                className
            }
            disabled={disabled}
        >
            <i className="ki-duotone ki-trash fs-3">
                <span className="path1"></span>
                <span className="path2"></span>
                <span className="path3"></span>
                <span className="path4"></span>
                <span className="path5"></span>
            </i>
            {children}
        </button>
    );
}
