export default function EditButton({
    href = "",
    className = "",
    disabled,
    children,
    ...props
}) {
    return (
        <a
            href={href}
            {...props}
            className={
                `btn btn-icon btn-bg-light btn-active-color-primary btn-sm btn-active-light-primary w-30px h-30px me-3 ` +
                className
            }
            disabled={disabled}
        >
            <i className="ki-duotone ki-pencil fs-3">
                <span className="path1"></span>
                <span className="path2"></span>
            </i>
            {children}
        </a>
    );
}
