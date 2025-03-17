import type { PageProps } from "@inertiajs/core";

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
}
