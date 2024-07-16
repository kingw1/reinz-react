import { Link } from "@inertiajs/react";
import React from "react";

export default function Pagination({ paginator }) {
    return (
        <nav className="d-flex justify-items-center justify-content-between">
            <div className="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                <div>
                    <p className="small text-muted">
                        <span>Showing</span>
                        <span className="px-1 fw-semibold">
                            {paginator.from}
                        </span>
                        <span>to</span>
                        <span className="px-1 fw-semibold">{paginator.to}</span>
                        <span>of</span>
                        <span className="px-1 fw-semibold">
                            {paginator.total}
                        </span>
                        <span>Results</span>
                    </p>
                </div>

                <div>
                    <ul className="pagination">
                        {paginator.links.map((link, i) => {
                            return (
                                <li key={i} className="page-item">
                                    <Link className="page-link" href={link.url}>
                                        <div
                                            dangerouslySetInnerHTML={{
                                                __html: link.label,
                                            }}
                                        />
                                    </Link>
                                </li>
                            );
                        })}
                    </ul>
                </div>
            </div>
        </nav>
    );
}
