import React from "react";

export default function Select({
    name,
    options,
    onChange,
    selectedOption,
    defaultOption = "Select",
}) {
    return (
        <select
            className="form-select form-select-solid"
            name={name}
            onChange={onChange}
            value={selectedOption | ""}
        >
            <option value="">{defaultOption}</option>
            {options.map((option, index) => (
                <option key={index} value={option.id}>
                    {option.label}
                </option>
            ))}
        </select>
    );
}
