import { useEffect, useState } from "react";
import { Box, Table, Text, SegmentedControl, Heading, Flex, Button } from "@radix-ui/themes";

const STATUS_LABELS = {
  0: "For Review",
  1: "Accepted",
  2: "Blocked",
};

const STATUS_COLORS = {
  0: "gray",
  1: "green",
  2: "red",
};

export default function AdminComments() {
  const [comments, setComments] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState();

  useEffect(() => {
    setLoading(true);
    fetch("/admin/comments/data")
      .then(res => {
        if (!res.ok) throw new Error("Failed to load comments");
        return res.json();
      })
      .then(data => {
        setComments(data);
        setError(undefined);
      })
      .catch(e => setError(e.message))
      .finally(() => setLoading(false));
  }, []);

  // Update comment status
  const updateStatus = async (commentId, newStatus) => {
    try {
      const res = await fetch(`/admin/comments/${commentId}`, {
        method: "PATCH",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "",
        },
        body: JSON.stringify({ status: newStatus }),
      });
      if (!res.ok) throw new Error("Update failed");
      setComments(comments =>
        comments.map(c =>
          c.id === commentId ? { ...c, status: newStatus } : c
        )
      );
    } catch (e) {
      alert(e.message);
    }
  };

  if (loading) return <Text>Loading comments...</Text>;
  if (error) return <Text color="red">{error}</Text>;
  if (comments.length === 0) return <Text>No comments found.</Text>;

  return (
    <Box style={{ backgroundColor: '#ccdee8', height: "100vh", overflowY: "auto", fontFamily: "Geist, sans-serif" }}>
      <Heading mb="5" mt="8">Comments</Heading>
      <Table.Root variant="surface" mt="5">
      <Table.Header>
          <Table.Row>
            <Table.ColumnHeaderCell>ID</Table.ColumnHeaderCell>
            <Table.ColumnHeaderCell>Comment</Table.ColumnHeaderCell>
            <Table.ColumnHeaderCell>Commented By</Table.ColumnHeaderCell>
            <Table.ColumnHeaderCell>Status</Table.ColumnHeaderCell>
          </Table.Row>
        </Table.Header>
        <Table.Body>
          {comments.map(comment => (
            <Table.Row key={comment.id}>
              <Table.Cell>{comment.id}</Table.Cell>
              <Table.Cell>{comment.comment_text}</Table.Cell>
              <Table.Cell>
                {comment.user?.full_name
                  ? `${comment.user.full_name} (${comment.user.id})`
                  : comment.user_id}
              </Table.Cell>
              <Table.Cell>
                <SegmentedControl.Root
                  value={String(comment.status)}
                  onValueChange={value => updateStatus(comment.id, Number(value))}
                  size="2"
                >
                  <SegmentedControl.Item value="0">{STATUS_LABELS[0]}</SegmentedControl.Item>
                  <SegmentedControl.Item value="1">{STATUS_LABELS[1]}</SegmentedControl.Item>
                  <SegmentedControl.Item value="2">{STATUS_LABELS[2]}</SegmentedControl.Item>
                </SegmentedControl.Root>
              </Table.Cell>
            </Table.Row>
          ))}
        </Table.Body>
      </Table.Root>
    </Box>
  );
}